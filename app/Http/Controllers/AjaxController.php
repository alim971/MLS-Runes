<?php

namespace App\Http\Controllers;

use App\Champion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AjaxController extends Controller
{
    public function getStatsForChampion() {
        $champion = Champion::find(\request()->get('id'));
        if($champion == null) {
            return response()->json(['message' => 'Custom'], 404);
        }
        return Response::json($champion);
//        return $champion->toJson();
    }

    public function getStatsForRune() {
        $rune = \request()->get('rune');
        $burst = \request()->get('burst');
        $poke = \request()->get('poke');
        $basic = \request()->get('ba');
        $tank = \request()->get('tank');
        $sustain = \request()->get('sustain');
        $utility = \request()->get('utility');
        $mobility = \request()->get('mobility');
        $difficulty = \request()->get('difficulty');
        $time = \request()->get('time');
        $minute = \request()->get('minute') ?? 0;
        $length = \request()->get('length');
        $number = \request()->get('number');
        $reached = \request()->get('reached') ?? 0;
        $opponentTank = \request()->get('tankOpp');
        $opponentUtility = \request()->get('utiOpp');
        $opponentAfter = \request()->get('afOn') ? true : false;
        $shutdowns = \request()->get('shutdown');
        $role = \request()->get('role');

        $dmg = 0;
        $heal = 0;
        $shield = 0;

        $data = [];

        if($rune == 'dh' && (($role == 'Mage' && $minute >= 9)
            || ($role == 'Carry' && $reached > $minute))) {
            $burstAll = $burst;
            for ($i = 0; $i < $shutdowns; $i++) {
                $burstAll *= 1.15;
            }
            $burstBonus = $burstAll - $burst;
            $data += [
                'bonusBurstMin' => round($burstBonus, 2),
                'burstTotalMin' => round($burstAll, 2),
                'min' => true
            ];
        }
        if($role == 'Mage') {
            for($i = 5; $i <= $minute; $i+=5) {
                $basic *= 1.15;
                $burst *= 1.15;
            }
        } else if ($role == 'Carry') {
            for($i = $reached; $i < $minute; $i++) {
                $basic *= 1.17;
                $burst *= 1.17;
            }
        } else if($role == 'Marksman') {
            for($i = 5; $i <= $minute; $i+=5) {
                $basic *= 1.15;
                $basic += 25;
            }
        } else if($role == 'Enchanter') {
            $shield = 10 * $minute;
        }

        if($rune == 'conq') {
            $increase = 0.1;
            $healing = 0.15;
            for($i = 0; $i < $time; $i++) {
                $dmg += $basic + $increase * $basic;
                $heal += $healing * ($basic + $increase * $basic);
                if($increase < 0.5) {
                    $increase += 0.1;
                }
            }
        } else if($rune == 'lt') {
            $increase = 0.7;
            for($i = 0; $i < $time; $i++) {
                $dmg += $basic + $increase * $basic;
                if($increase > 0) {
                    $increase -= 0.05;
                }
            }
        } else if($rune == 'pta') {
            $increase = 0.06;
            for($i = 0; $i < $time; $i++) {
                $dmg += $basic + $increase * $basic;
                $increase += 0.06;
            }
        } else if($rune == 'hob') {
            $increase = 0.25;
            for($i = 0; $i < $time; $i++) {
                $dmg += $basic + $increase * $burst;
            }
        } else if($rune == 'ff') {
            $healBase = 0;
            $healFight = 0;
            for($i = 1; $i <= $length; $i++) {
                $healBase += $i * 27;
            }
            for($i = 0; $i < $time; $i += 4) {
                $healFight +=  $minute * 27;
            }
            $heal = $healBase + $healFight;
            $data += [
                'base' => $healBase,
                'fight' => $healFight,
            ];
        } else if($rune == 'af') {
            $resist = $tank * (min($utility, 70)/100);
            $resistAll = 0;
            for($i = 1; $i <= $number; $i++) {
                $resistAll += $resist;
            }

            $data += [
                'after' => round($tank + $resist, 2),
                'afterAll' => round($resistAll,2),
                'bonus' => round($resist, 2)
            ];
        } else if($rune == 'ele') {
            $burstBonus = $burst * 0.75 + (20*$minute);
            $opponentTank += $opponentTank * ($opponentAfter ? (min($opponentUtility, 70)/100) : 0);
            $negate = $opponentTank * 0.1;
            $data += [
                'burst' => round($burstBonus, 2),
                'negate' => round($negate,2),
                'burstTotal' => $burst + $burstBonus,
            ];
        } else if($rune == 'dh') {
            $burstAll = $burst;
            for($i = 0; $i < $shutdowns; $i++) {
                $burstAll *= 1.15;
            }
            $burstBonus = $burstAll - $burst;
            $data += [
                'bonusBurstMax' => round($burstBonus, 2),
                'burstTotalMax' => round($burstAll,2),
            ];
        } else if($rune == 'gu') {
            $bonusShield = $shield * 1.4;
            $data += [
                'bonusShield' => round($bonusShield, 2),
                'totalShield' => round($shield + $bonusShield, 2),
            ];
        }
        else {
            flash('Not recognized rune')->error();
        }
        $data += [
            'dmg' => round($dmg,2),
            'heal' => round($heal, 2),
            'shield' => round($shield, 2),
        ];
        return Response::json($data);
//        return $champion->toJson();
    }
}
