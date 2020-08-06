<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <style>
        html, body {
            background-color: rgba(0, 0, 0, 0.69);
            /*color: #636b6f;*/
            color: #d2dbe0;
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

        .title {
            font-size: 84px;
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

        input, select {
            color: black;
            background: #d2dbe0;
        }

        input[number] {
            margin-left: 10px;
            height: 40px;
            width: 40px;
        }

        label {
            color: #d2dbe0;
            margin-left: 15px;
            margin-right: 15px;
        }


        .bigger {
            font-size: 1.6rem;
            font-weight: bold;
        }

        .bigger2 {
            font-size: 1.8rem;
            font-weight: bold;
        }

        .bigger3 {
            font-size: 1.95rem;
            font-weight: bold;
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
            var unit = $(this).attr('id') === 'time' ? ' second' : ' minute';
            unit += $(this).val() === 1 ? '' : 's';
            $(this).next().html($(this).val() + unit);
            f();
        });

        $(document).on('input', 'input[type=number]', function() {
            f();
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
            if($(this).val() === 'ff') {
                $('#minuteDiv').removeClass('collapse');
                $('#lengthDiv').removeClass('collapse');
                $('#ffDiv').removeClass('collapse');
            } else {
                $('#minuteDiv').addClass('collapse');
                $('#lengthDiv').addClass('collapse');
                $('#ffDiv').addClass('collapse');
            }
            f();
            // myDiv.style.display = (this.selectedIndex == 0) ? "block" : "none";
        });

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
        <div>
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
                <div class="bigger2">
                    <label for="time">Time in fight (1 - 100)</label>
                    <input class="changeInput" type="range" min="1" max="100" value="1" step="1" name="time" id="time"/>
                    <span class="">1 second</span>
                </div>

                <br>
                <br>

                <div class="bigger2 collapse" id="minuteDiv">
                    <label for="minute">Minute of the game (1 - 70)</label>
                    <input class="changeInput" type="range" min="1" max="70" value="1" step="1" name="minute" id="minute"/>
                    <span class="">1 minute</span>
                </div>

                <div class="bigger2 collapse" id="lengthDiv">
                    <label for="time">Length of the game (1 - 70)</label>
                    <input class="changeInput" type="range" min="1" max="70" value="1" step="1" name="length" id="length"/>
                    <span class="">1 minute</span>
                </div>
                {{--                        </li>--}}
                <br>
                <br>
                <br>
                <div>
                    <label for="runeSelect">Select rune:</label>
                    <select id="runeSelect" class="" name="rune">
                        <option disabled selected value> -- select a rune -- </option>
                        <option value="conq">Conqueror</option>
                        <option value="lt">Lethal tempo</option>
                        <option value="pta">Press the attack</option>
                        <option value="hob">Hail of Blades</option>
                        <option value="ff">Fleet Footwork</option>
                    </select>
                </div>
            </form>
            <br>
            <br>
            <div class="bigger3">
                <label for="dmg">Damage done:</label>
                <input readonly disabled type="number" id="dmg" name="dmg"/>
                <label for="heal">Healing done:</label>
                <input readonly disabled type="number" id="heal" name="heal"/>
                <br>
                <div id="ffDiv" class="collapse">
                    <label for="base">Healing done outside fight:</label>
                    <input readonly disabled type="number" id="base" name="base"/>
                    <label for="fight">Healing done during fight:</label>
                    <input readonly disabled type="number" id="fight" name="fight"/>
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
        </div>
        <br>
    </div>
</div>
</body>
</html>
