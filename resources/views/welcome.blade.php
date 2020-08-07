<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <style>

        /*html, body .white {*/
        /*    !*background-color: rgba(255, 255, 255, 0.88)!important;*!*/
        /*    color: #636b6f;*/
        /*}*/
        .white {
            background-color: rgba(255, 255, 255, 0.88);

        }

        select.white {
            background-color: white;
        }

        html, body:not(.white) {
            /*background-color: #191a1b; */
            /*background-color: #242626;*/
            background-color: rgba(0, 0, 0, 0.69);
            /*color: #636b6f;*/
            color: #d2dbe0;
        }

        html, body:not(.white) {
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .collapse {
            visibility: collapse;
        }

        .btn {
            width: 112px;
        }

        .title {
            font-size: 84px;
        }

        .title.while {
            color: #636b6f;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        select {
            height: 40px;
            width: 45%;
            border-width: 2px;
        }

        input, select:not(.white) {
            color: black;
            background: #d2dbe0;
        }

        input, select {
            font-weight: 700;
        }

        input[number] {
            margin-left: 10px;
            height: 40px;
            width: 40px;
        }

        label.white {
            color: #d2dbe0;
        }

        label {
            margin-left: 15px;
            margin-right: 15px;
        }


        .bigger {
            font-size: 1.1em;
            font-weight: bold;
        }

        .bigger2 {
            font-size: 1.2em;
            font-weight: bold;
        }

        .bigger3 {
            font-size: 1.3em;
            font-weight: bold;
        }

        input[type=range] {
            display: block;
            width: 100%;
        }

        .mode {
            float: right;
            margin-right: 25px;
        }

        .inline {
            display: inline;
        }

        .inline-container {
            display: flex;
            justify-content: center;
        }

        .getBorder {

        }
    </style>
    <script>
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>
    <script>
        // $('#time').bind('change', function() {
        //     $('#textInput').val($('#time').val());
        //     if($('#runeSelect').val() != null) {
        //         f();
        //     }
        // });
        $(document).on('change mousemove', 'input[type=range]', function() {
            // $(document).on('change', '#time', function() {
            var id = $(this).attr('id');
            var unit = id === 'time' ? ' second' : id === 'number' ? ' fight' : ' minute';
            unit += $(this).val() == 1 ? '' : 's';
            $(this).next().html($(this).val() + unit);
            f();
        });

        $(document).on('input', 'input[type=number]', function() {
            f();
        });

        $(document).on('click', '#dark', function() {
            var dark = $(".white").length <= 0;
            if(dark) {
                $('#dark').html('Dark Mode');
                $('#dark').removeClass('btn-white');
                $('#dark').addClass('btn-dark');
            } else {
                $('#dark').html('White Mode');
                $('#dark').removeClass('btn-dark');
                $('#dark').addClass('btn-white');
            }
            // for(var i = 0; i < allInputs.length; i++) {
            if(dark) {
                $('input').addClass('white');
                $('body').addClass('white');
                $('select').addClass('white');
            }
            else {
                $('input').removeClass('white');
                $('body').removeClass('white');
                $('select').removeClass('white');
            }
            // }
        });

        // var myDiv = document.getElementById("myDiv");
        $(document).on('change', '#mySelect', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            });

            $.ajax({
                method: 'POST',
                url   : "{{ route('select') }}",
                data  : {
                    id: $(this).val(),
                }
            }).success(function (data) {
                $('#burst').val(data['burst']);
                $('#poke').val(data['poke']);
                $('#ba').val(data['basic']);
                $('#tank').val(data['tank']);
                $('#sustain').val(data['sustain']);
                $('#utility').val(data['utility']);
                $('#mobility').val(data['mobility']);
                $('#difficulty').val(data['difficulty']);
                f();
            });
            // myDiv.style.display = (this.selectedIndex == 0) ? "block" : "none";
        });
        $(document).on('change', '#runeSelect', function() {
            var rune = $(this).val();

            switch(rune) {
                case 'conq':
                    uncollapseDmg();
                    uncollapseHeal();
                    collapseFF();
                    collapseAf();
                    break;
                case 'lt':
                case 'hob':
                case 'pta':
                    uncollapseDmg();
                    collapseHeal();
                    collapseFF();
                    collapseAf();
                    break;
                case 'ff':
                    collapseDmg();
                    collapseHeal();
                    uncollapseFF();
                    collapseAf();
                    break;
                case 'af':
                    collapseDmg();
                    collapseHeal();
                    collapseFF();
                    uncollapseAf();
                    break;
                default:
                    break;
                // code block
            }

            if(rune === 'conq') {
            } else if(rune === 'c') {
            } else if(rune === 'pta') {
            } else if(rune === 'hob') {
            } else if(rune === 'ff') {
            } else if(rune === 'af') {
            } else {
            }

            if(rune === 'ff') {
                uncollapseFF();
            } else if(rune === 'af') {
                collapseFF();
            }
            f();
            // myDiv.style.display = (this.selectedIndex == 0) ? "block" : "none";
        });

        function collapseDmg() {
            if($('#dmgDiv').hasClass("collapse")) {
                return;
            }
            $('#dmgDiv').addClass('collapse');
            $('#dmg').val(0);
        }

        function uncollapseDmg() {
            $('#dmgDiv').removeClass('collapse');
        }

        function collapseHeal() {
            if($('#healDiv').hasClass("collapse")) {
                return;
            }
            $('#healDiv').addClass('collapse');
            $('#heal').val(0);
        }

        function uncollapseHeal() {
            $('#healDiv').removeClass('collapse');
        }

        function collapseFF() {
            if($('#minuteDiv').hasClass("collapse")) {
                return;
            }
            $('#minuteDiv').addClass('collapse');
            $('#lengthDiv').addClass('collapse');
            $('#ffDiv').addClass('collapse');
            $('#minute').val('1 minute');
            $('#length').val('1 minute');
        }

        function uncollapseFF() {
            $('#minuteDiv').removeClass('collapse');
            $('#lengthDiv').removeClass('collapse');
            $('#ffDiv').removeClass('collapse');
            // $('#minute').val(1);
            // $('#length').val(1);
        }

        function collapseAf() {
            if($('#afterDiv').hasClass("collapse")) {
                return;
            }
            $('#afterDiv').addClass('collapse');
            $('#numberDiv').addClass('collapse');
            $('#timeDiv').removeClass('collapse');
            $('#number').val('1 fight');
        }

        function uncollapseAf() {
            $('#afterDiv').removeClass('collapse');
            $('#numberDiv').removeClass('collapse');
            $('#timeDiv').addClass('collapse');

        }

        function f() {
            if($('#runeSelect').val() == null) {
                return;
            }
            var formData = new FormData(document.querySelector('form'));

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            });

            $.ajax({
                method: 'POST',
                url   : "{{ route('rune') }}",
                data  : formData,
                processData: false,
                contentType: false
            }).success(function (data) {
                $('#dmg').val(data['dmg']);
                $('#heal').val(data['heal']);
                $('#base').val(data['base']);
                $('#fight').val(data['fight']);
                $('#after').val(data['after']);
                $('#afterAll').val(data['afterAll']);
                $('#bonus').val(data['bonus'] + ' (' + data['after'] + ' total)');
            });
        }
    </script>
</head>
<body>
<div class="flex-center position-ref full-height">
    @include('flash::message')

    <div class="content bigger">
        <div class="title m-b-md">
            MLS - Runes
        </div>
        <label for="myForm">Select champion:</label>

        <div>
            <button type="button" class="btn btn-white mode" id="dark">White mode</button>

            <select class="" id="mySelect">
                <option value="Custom">Custom</option>
                @foreach(\App\Champion::orderBy('name')->get() as $champion)
                    <option value="{{ $champion->id }}">{{ $champion->name }}</option>
                @endforeach
            </select>
        </div>
        <br>
        <br>
        <br>
        <div class="getBorder">
            <form method="post" action="{{ route('rune') }}" id="myForm">
                <label for="burst">Burst</label>
                <input type="number" min="0" max="100" step="10" name="burst" id="burst"/>

                <label for="poke">Poke</label>
                <input type="number" min="0" max="100" step="10" name="poke" id="poke"/>

                <label for="ba">Basic attacks</label>
                <input type="number" min="0" max="100" step="10" name="ba" id="ba"/>

                <label for="tank">Tank</label>
                <input type="number" min="0" max="100" step="10" name="tank" id="tank"/>

                <label for="sustain">Sustain</label>
                <input type="number" min="0" max="100" step="10" name="sustain" id="sustain"/>

                <label for="utility">Utility</label>
                <input type="number" min="0" max="100" step="10" name="utility" id="utility"/>

                <label for="mobility">Mobility</label>
                <input type="number" min="0" max="100" step="10" name="mobility" id="mobility"/>

                <label for="difficulty">Difficulty</label>
                <input type="number" min="0" max="10" step="1" name="difficulty" id="difficulty"/>

                <br>
                <br>
                <br>
                {{--                        <li>--}}
                <div class="bigger2" id="timeDiv">
                    <label for="time">Time in fight (1 - 100)</label>
                    <input class="changeInput" type="range" min="1" max="100" value="1" step="1" name="time" id="time"/>
                    <span class="">1 second</span>
                </div>

                <br>

                <div class="bigger2 collapse" id="minuteDiv">
                    <label for="minute">Minute of the game (1 - 70)</label>
                    <input class="changeInput" type="range" min="1" max="70" value="1" step="1" name="minute" id="minute"/>
                    <span class="">1 minute</span>
                    <br>
                    <br>

                </div>

                <div class="bigger2 collapse" id="lengthDiv">
                    <label for="length">Length of the game (1 - 70)</label>
                    <input class="changeInput" type="range" min="1" max="70" value="1" step="1" name="length" id="length"/>
                    <span class="">1 minute</span>
                    <br>
                    <br>

                </div>

                <div class="bigger2 collapse" id="numberDiv">
                    <label for="number">Number of fights in a game (1 - 100)</label>
                    <input class="changeInput" type="range" min="1" max="100" value="1" step="1" name="number" id="number"/>
                    <span class="">1 fight</span>
                    <br>
                    <br>

                </div>
                {{--                        </li>--}}
                <div>
                    <label for="runeSelect">Select rune:</label>
                    <select id="runeSelect" class="" name="rune">
                        <option disabled selected value> -- select a rune -- </option>
                        <optgroup label="Precision">
                            <option value="conq">Conqueror</option>
                            <option value="ff">Fleet Footwork</option>
                            <option value="lt">Lethal tempo</option>
                            <option value="pta">Press the attack</option>
                        </optgroup>
                        <optgroup label="Domination">
                            <option value="hob">Hail of Blades</option>
                        </optgroup>
                        <optgroup label="Resolve">
                            <option value="af">Aftershock</option>
                        </optgroup>
                    </select>
                </div>
            </form>
            <br>
            <br>
        </div>
            <div class="bigger3 getBorder">
                <div class="inline-container">
                    <div class="inline collapse" id="dmgDiv">
                        <label for="dmg">Damage done:</label>
                        <input readonly disabled type="number" id="dmg" name="dmg"/>
                        <br>
                    </div>
                    <div class="inline collapse" id="healDiv">
                        <label for="heal">Healing done:</label>
                        <input readonly disabled type="number" id="heal" name="heal"/>
                        <br>
                    </div>
                </div>

                <div id="ffDiv" class="collapse">
                    <label for="base">Healing done outside fight:</label>
                    <input readonly disabled type="number" id="base" name="base"/>
                    <label for="fight">Healing done during fight:</label>
                    <input readonly disabled type="number" id="fight" name="fight"/>
                </div>
                <div class="collapse" id="afterDiv">
                    <label for="bonus">Bonus Resistance at initiation:</label>
                    <input readonly disabled type="text" id="bonus" name="bonus"/>
                    <label for="afterAll">Total bonus resistance:</label>
                    <input readonly disabled type="number" id="afterAll" name="afterAll"/>
                    <div class="collapse" style="text-align: left; margin-left: 15px">
                        <label for="after">Total Resistance at initiation:</label>
                        <input readonly disabled type="number" id="after" name="after"/>
                    </div>
                </div>
            </div>

            {{--                    <table id="myTable" style="visibility: collapse">--}}
            {{--                        <thead>--}}
            {{--                            <th>Name</th>--}}
            {{--                            <th>Burst</th>--}}
            {{--                            <th>Poke</th>--}}
            {{--                            <th>Basic attacks</th>--}}
            {{--                            <th>Tank</th>--}}
            {{--                            <th>Sustain</th>--}}
            {{--                            <th>Utility</th>--}}
            {{--                            <th>Mobility</th>--}}
            {{--                            <th>Difficulty</th>--}}
            {{--                        </thead>--}}
            {{--                        <tbody>--}}
            {{--                            <tr>--}}
            {{--                                <th></th>--}}
            {{--                                <th>Burst</th>--}}
            {{--                                <th>Poke</th>--}}
            {{--                                <th>Basic attacks</th>--}}
            {{--                                <th>Tank</th>--}}
            {{--                                <th>Sustain</th>--}}
            {{--                                <th>Utility</th>--}}
            {{--                                <th>Mobility</th>--}}
            {{--                                <th>Difficulty</th>--}}
            {{--                            </tr>--}}
            {{--                        </tbody>--}}
            {{--                    </table>--}}
{{--        </div>--}}
        <br>
    </div>
</div>
</body>
</html>
