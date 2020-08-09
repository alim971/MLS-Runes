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

    public function getScaledStatsForChampion() {
        $role = \request()->get('role');
        $burst = \request()->get('burst');
        $basic = \request()->get('ba');
        $minute = \request()->get('minute');
        $reached = \request()->get('reached');
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
        }

        $data = [
            'burstScale' => $burst,
            'baScale' => $basic,
        ];
        return Response::json($data);
//        return $champion->toJson();
    }

    public function getStatsForRune() {
        $rune = \request()->get('rune');
        $burst = \request()->get('burst');
        $poke = \request()->get('poke');
        $basic = \request()->get('ba');
        $tank = \request()->get('tank') * 0.6;
        $sustain = \request()->get('sustain');
        $utility = \request()->get('utility');
        $mobility = \request()->get('mobility');
        $difficulty = \request()->get('difficulty');
        $time = \request()->get('time');
        $minute = \request()->get('minute') ?? 0;
        $length = \request()->get('length');
        $number = \request()->get('number');
        $reached = \request()->get('reached') ?? 0;
        $opponentTank = \request()->get('resistanceOpp');
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
            for($i = 4; $i <= $time; $i += 4) {
                $healFight +=  $minute * 27;
            }
            $heal = $healBase + $healFight;
            $data += [
                'base' => $healBase,
                'fight' => $healFight,
            ];
        } else if($rune == 'af') {
            $resist = $tank * (min($utility, 70)/100);
//            $resist = min($tank * 1.85, $tank * (min($utility, 70)/100));
            $cap = 85;
            $all = $tank + $resist;
//            if($cap < $resist) {
            if($cap < $all) {
                $diff = $all - $cap;
                $resist -= $diff;
                $data += [
                    'overcapped' => true,
                    'over' => round($all - $cap, 2)
//                    'diff' => round($utility - 70, 2)
                ];
                $all = $cap;
            }
            $resistAll = 0;
            for($i = 1; $i <= $number; $i++) {
                $resistAll += $resist;
            }

            $data += [
                'after' => round($all, 2),
                'afterAll' => round($resistAll,2),
                'bonus' => round($resist, 2)
            ];
        } else if($rune == 'ele') {
            $burstBonus = $burst * 0.75 + (20*$minute);
            if($opponentAfter) {
                $opponentTank = min(85, $tank * (1 +  (min($utility, 70) / 100)));
            }
                //$opponentTank * ($opponentAfter ? (min($opponentUtility, 70)/100) : 0);
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
        } else if($rune == 'comet') {
            $bonusPoke = $poke * 0.66;
            $data += [
                'bonusPoke' => round($bonusPoke, 2),
                'totalPoke' => round($poke + $bonusPoke, 2),
            ];
        } else if($rune == 'aery') {
            $bonusPoke = $poke * 0.45;
            $increase = 0.25 * ($poke + $bonusPoke);
//            $dmgAery = 0;
            for($i = 0; $i < $time; $i++) {
                $dmg += $basic + $increase * $basic;
            }
            $data += [
                'bonusPokeAe' => round($bonusPoke, 2),
                'totalPokeAe' => round($poke + $bonusPoke, 2),
                'bonusDps'  => round($increase, 2),
//                'dmgAery'   => round($dmgAery, 2)
            ];
        } else if($rune == 'rush') {
            $bonusMob = $mobility * 0.08;
            $totalMob = $mobility + $bonusMob;
            $bonusMobFig = $totalMob * 0.40;
            $data += [
                'bonusMob' => round($bonusMob, 2),
                'totalMob' => round($totalMob, 2),
                'bonusMobFig' => round($bonusMobFig, 2),
                'totalMobFig' => round($totalMob + $bonusMobFig, 2),
            ];
        } else if($rune == 'gl') {
            $totalUtil = $utility + 30;
            $cap = 99;
            if($cap < $totalUtil) {
                $overUtil = $totalUtil - $cap;
                $totalUtil = $cap;
                $data += [
                    'overUtil' => $overUtil,
                ];
            }
            $data += [
                'totalUtil' => $totalUtil,
            ];
        } else if($rune == 'klepto') {
            $bonusGold = $poke / 2;
            $data += [
                'bonusGold' => round($bonusGold, 2),
            ];
        }
//        else {
//            flash('Not recognized rune')->error();
//        }
        $dmgBase = $basic * $time;
        $dmgRune = $dmg - $dmgBase;

        $data += [
            'dmg' => round($dmg,2),
            'dmgRune' => round($dmgRune, 2),
            'heal' => round($heal, 2),
            'shield' => round($shield, 2),
            'burstScaled' => round($burst, 2),
            'baScaled' => round($basic, 2),
        ];
        return Response::json($data);
//        return $champion->toJson();
    }
}
