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


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

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
            /*height: 100vh;*/
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
            display: none!important;
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

        input[type=text] {
            text-align: center;
        }

        input[number] {
            margin-left: 10px;
            height: 40px;
            width: 40px;
        }

        #scaled input {
            width: 22%;
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
            width: 94%;
            /*margin-right: 10px;*/
            margin-left: 20px;
        }

        .mode {
            float: right;
            margin-right: 25px;
        }

        .inline {
            display: inline;
        }

        .inline-block {
            display: inline-block;
        }

        .inline-container {
            display: flex;
            justify-content: center;
        }

        .scroll-container {
            margin: auto;
            max-height: 100%;
            overflow: auto;
        }

        .getBorder {

        }

        .result input {
            width: 95%;

            /*text-align: center;*/
        }

        .danger {
            /*color: #fff;*/
            color: #bd2130;
            border-color: #b21f2d;
        }

        .danger-input {
            background-color: #b21f2d;
        }
    </style>
    <script>
        // $('#time').bind('change', function() {
        //     $('#textInput').val($('#time').val());
        //     if($('#runeSelect').val() != null) {
        //         f();
        //     }
        // });

        $(document).on('change', '#checkChamps', function () {
            if($(this).is(':checked')) {
                $('#mySelect').addClass('collapse')
                $('#roleSelect').removeClass('collapse');
                $('#roleSelect option[value="' + $('#mySelect').val() + '"]').attr("selected", "selected");
            } else {
                $('#mySelect').removeClass('collapse')
                $('#roleSelect').addClass('collapse');
                $('#mySelect option[value="' + $('#roleSelect').val() + '"]').attr("selected", "selected");

            }
        })

        $(document).on('change mousemove', 'input[type=range]', function() {
            // $(document).on('change', '#time', function() {
            var id = $(this).attr('id');
            var unit;
            switch (id) {
                case 'time':
                    unit = ' second';
                    break;
                case 'length':
                case 'minute':
                case 'reached':
                    unit = ' minute';
                    break;
                case 'number':
                    unit = ' fight';
                    break;
                case 'shutdown':
                    unit = ' shutdown'
            }
            // var unit = id === 'time' ? ' second' : id === 'number' ? ' fight' : id ===  ' minute';
            unit += $(this).val() == 1 ? '' : 's';
            $(this).next().html($(this).val() + unit);
            f();
        });

        $(document).on('input', 'input[type=number]', function() {
            f();
        });

        $(document).on('input change', '#tank', function() {
            var res = parseFloat($(this).val()) * 0.6;
            res = +res.toFixed(2);
            $('#resistance').val(res);
        });

        $(document).on('input change', '#tankOpp', function() {
            var res = parseFloat($(this).val()) * 0.6;
            res = +res.toFixed(2);
            $('#resistanceOpp').val(res);
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
        $(document).on('change', '.champSelect', function() {
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
                $('#tank').val(data['tank']).trigger('change');
                $('#sustain').val(data['sustain']);
                $('#utility').val(data['utility']);
                $('#mobility').val(data['mobility']);
                $('#difficulty').val(data['difficulty']);
                $('#role').val(data['role']);

                if($('#role').val() == "") {
                    if(!$('#minuteDiv').hasClass('collapse'))
                        $('#minuteDiv').addClass('collapse');
                } else {
                    $('#minuteDiv').removeClass('collapse');
                }

                if($('#role').val() == "Carry"){
                    $('#reachedDiv').removeClass('collapse');
                } else if($('#role').val() != "Carry") {
                    if(!$('#reachedDiv').hasClass('collapse'))
                        $('#reachedDiv').addClass('collapse');
                }

                if($('#role').val() == "Enchanter"){
                    $('#shieldDiv').removeClass('collapse');
                } else if($('#role').val() != "Enchanter") {
                    if(!$('#shieldDiv').hasClass('collapse'))
                        $('#shieldDiv').addClass('collapse');
                }

                f();
            }).error(function (data) {
                $('#role').val("");
                $('#burst').val(0);
                $('#poke').val(0);
                $('#ba').val(0);
                $('#tank').val(0);
                $('#resistance').val(0);
                $('#sustain').val(0);
                $('#utility').val(0);
                $('#mobility').val(0);
                $('#difficulty').val(0);
                if(!$('#minuteDiv').hasClass('collapse')) {
                    $('#minuteDiv').addClass('collapse');
                }

                if(!$('#reachedDiv').hasClass('collapse')) {
                    $('#reachedDiv').addClass('collapse');
                }

                }

            );
            // myDiv.style.display = (this.selectedIndex == 0) ? "block" : "none";
        });

        $(document).on('change', '#afOn', function() {
            f();
        });

        $(document).on('change', '#opponentSelect', function() {
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
                $('#tankOpp').val(data['tank']).trigger('change');
                $('#utiOpp').val(data['utility']);
                f();
            }).error(function (data) {
                $('#tankOpp').val(0).trigger('change');
                $('#utiOpp').val(0);
                f();
            });
            // myDiv.style.display = (this.selectedIndex == 0) ? "block" : "none";
        });

        $(document).on('change', '#runeSelect', function() {
            f();
            var rune = $(this).val();

            switch(rune) {
                case 'conq':
                    uncollapseDmg();
                    uncollapseHeal();
                    collapseFF();
                    collapseAf();
                    collapseEle();
                    collapseDh();
                    collapseGu();
                    collapseComet();
                    collapseAery();
                    collapseRush();
                    collapseGl();
                    collapseKlepto();
                    break;
                case 'ff':
                    collapseDmg();
                    collapseHeal();
                    uncollapseFF();
                    collapseAf();
                    collapseEle();
                    collapseDh();
                    collapseGu();
                    collapseComet();
                    collapseAery();
                    collapseRush();
                    collapseGl();
                    collapseKlepto();
                    break;
                case 'lt':
                case 'pta':
                case 'hob':
                    uncollapseDmg();
                    collapseHeal();
                    collapseFF();
                    collapseAf();
                    collapseEle();
                    collapseDh();
                    collapseGu();
                    collapseComet();
                    collapseAery();
                    collapseRush();
                    collapseGl();
                    collapseKlepto();
                    break;
                case 'ele':
                    collapseDmg();
                    collapseHeal();
                    collapseFF();
                    collapseAf();
                    uncollapseEle();
                    collapseDh();
                    collapseGu();
                    collapseComet();
                    collapseAery();
                    collapseRush();
                    collapseGl();
                    collapseKlepto();
                    break;
                case 'dh':
                    collapseDmg();
                    collapseHeal();
                    collapseFF();
                    collapseAf();
                    collapseEle();
                    uncollapseDh();
                    collapseGu();
                    collapseComet();
                    collapseAery();
                    collapseRush();
                    collapseGl();
                    collapseKlepto();
                    break;
                case 'af':
                    collapseDmg();
                    collapseHeal();
                    collapseFF();
                    uncollapseAf();
                    collapseEle();
                    collapseDh();
                    collapseGu();
                    collapseComet();
                    collapseAery();
                    collapseRush();
                    collapseGl();
                    collapseKlepto();
                    break;
                case 'gu':
                    collapseDmg();
                    collapseHeal();
                    collapseFF();
                    collapseAf();
                    collapseEle();
                    collapseDh();
                    uncollapseGu();
                    collapseComet();
                    collapseAery();
                    collapseRush();
                    collapseGl();
                    collapseKlepto();
                    break;
                case 'comet':
                    collapseDmg();
                    collapseHeal();
                    collapseFF();
                    collapseAf();
                    collapseEle();
                    collapseDh();
                    uncollapseGu();
                    uncollapseComet();
                    collapseAery();
                    collapseRush();
                    collapseGl();
                    collapseKlepto();
                    break;
                case 'aery':
                    collapseDmg();
                    collapseHeal();
                    collapseFF();
                    collapseAf();
                    collapseEle();
                    collapseDh();
                    uncollapseGu();
                    collapseComet();
                    uncollapseAery();
                    collapseRush();
                    collapseGl();
                    collapseKlepto();
                    break;
                case 'rush':
                    collapseDmg();
                    collapseHeal();
                    collapseFF();
                    collapseAf();
                    collapseEle();
                    collapseDh();
                    uncollapseGu();
                    collapseComet();
                    collapseAery();
                    uncollapseRush();
                    collapseGl();
                    collapseKlepto();
                    break;
                case 'gl':
                    collapseDmg();
                    collapseHeal();
                    collapseFF();
                    collapseAf();
                    collapseEle();
                    collapseDh();
                    uncollapseGu();
                    collapseComet();
                    collapseAery();
                    collapseRush();
                    uncollapseGl();
                    collapseKlepto();
                    break;
                case 'klepto':
                    uncollapseDmg();
                    collapseHeal();
                    collapseFF();
                    collapseAf();
                    collapseEle();
                    collapseDh();
                    collapseGu();
                    collapseComet();
                    collapseAery();
                    collapseRush();
                    collapseGl();
                    uncollapseKlepto();
                    break;
                default:
                    break;
                // code block
            }
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
            if($('#ffDiv').hasClass("collapse")) {
                return;
            }
            if($('#role').val() == "") {
                $('#minuteDiv').addClass('collapse');
            }
            $('#lengthDiv').addClass('collapse');
            $('#ffDiv').addClass('collapse');
            // $('#minute').val('1 minute');
            // $('#length').val('1 minute');
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

        function collapseEle() {
            if($('#eleDiv').hasClass("collapse")) {
                return;
            }
            $('#eleDiv').addClass('collapse');
            $('#opponentDiv').addClass('collapse');
            $('#timeDiv').removeClass('collapse');
            $('#tankOpp').val(0);
            $('#opponentSelect')[0].selectedIndex = 0
        }

        function uncollapseEle() {
            $('#eleDiv').removeClass('collapse');
            $('#opponentDiv').removeClass('collapse');
            $('#timeDiv').addClass('collapse');

        }

        function collapseDh() {
            if($('#dhDiv').hasClass("collapse")) {
                return;
            }
            $('#dhDiv').addClass('collapse');
            $('#shutdownDiv').addClass('collapse');
            $('#shutdown').val('0 shutdowns');
            $('#timeDiv').removeClass('collapse');

        }

        function uncollapseDh() {
            $('#dhDiv').removeClass('collapse');
            $('#shutdownDiv').removeClass('collapse');
            $('#timeDiv').addClass('collapse');
        }

        function collapseGu() {
            if($('#guardianDiv').hasClass("collapse")) {
                return;
            }
            $('#guardianDiv').addClass('collapse');
            $('#bonusShield').val(0);

        }

        function uncollapseGu() {
            //$('#role').val() == "Enchanter"
            $('#guardianDiv').removeClass('collapse');

        }

        function collapseComet() {
            if($('#cometDiv').hasClass("collapse")) {
                return;
            }
            $('#cometDiv').addClass('collapse');
            $('#timeDiv').removeClass('collapse');
            $('#bonusPoke').val(0);
            $('#totalPoke').val(0);

        }

        function uncollapseComet() {
            $('#cometDiv').removeClass('collapse');
            $('#timeDiv').addClass('collapse');

        }

        function collapseAery() {
            if($('#aeryDiv').hasClass("collapse")) {
                return;
            }
            $('#aeryDiv').addClass('collapse');
            $('#bonusPokeAe').val(0);
            $('#bonusDps').val(0);
        }

        function uncollapseAery() {
            $('#aeryDiv').removeClass('collapse');
        }

        function collapseRush() {
            if($('#rushDiv').hasClass("collapse")) {
                return;
            }
            $('#rushDiv').addClass('collapse');
            $('#timeDiv').removeClass('collapse');
            $('#bonusMob').val(0);
            $('#bonusMobFig').val(0);
        }

        function uncollapseRush() {
            $('#rushDiv').removeClass('collapse');
            $('#timeDiv').addClass('collapse');

        }

        function collapseGl() {
            if($('#glDiv').hasClass("collapse")) {
                return;
            }
            $('#glDiv').addClass('collapse');
            $('#timeDiv').removeClass('collapse');
            $('#totalUtil').val(0);
        }

        function uncollapseGl() {
            $('#glDiv').removeClass('collapse');
            $('#timeDiv').addClass('collapse');
        }

        function collapseKlepto() {
            if($('#kleptoDiv').hasClass("collapse")) {
                return;
            }
            $('#kleptoDiv').addClass('collapse');
            $('#timeDiv').removeClass('collapse');
            $('#bonusGold').val(0);
        }

        function uncollapseKlepto() {
            $('#kleptoDiv').removeClass('collapse');
            $('#timeDiv').addClass('collapse');
        }

        function capitalFirst(string)
        {
            if(string != null) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }
        }

        function f() {
            // if($('#runeSelect').val() == null) {
            //     return;
            // }
            $('#dmg').val("");
            $('#bonus').val("");
            $('#bonusBur').val("");
            $('#bonusBurstDh').val("");
            $('#totalBurDh').val("");
            $('#bonusPokeAe').val("");
            $('#dmgAery').val("");
            $('#bonusMob').val("");
            $('#bonusMobFig').val("");
            $('#bonusShield').val("");
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
                if(data['dmgRune'] >= 0) {
                    $('#dmg').val(data['dmg'] + ' (Bonus ' + capitalFirst($('#runeSelect').val()) + ' dmg: ' + data['dmgRune'] + ')');
                }
                $('#heal').val(data['heal']);
                $('#base').val(data['base']);
                $('#fight').val(data['fight']);
                //$('#after').val(data['after']);
                $('#afterAll').val(data['afterAll']);
                if(data['overcapped']) {
                    $('#overcappedDiv').removeClass('collapse');
                    $('#over').val(data['over']);
                } else if($('#overcappedDiv').hasClass('collapse')){
                    $('#overcappedDiv').addClass('collapse');
                    $('#over').val(0);
                }
                if(data['bonus']) {
                    $('#bonus').val(data['bonus'] + ' (' + data['after'] + ' total)');
                }
                if(data['bonusBur']) {
                    $('#bonusBur').val(data['burst'] + ' (' + data['burstTotal'] + ' total)');
                }
                $('#negate').val(data['negate']);
                var bonus, total, bonusLabel, totalLabel;
                if(data['min']) {
                    bonusLabel = 'Bonus burst in range of: ';
                    totalLabel = 'Total burst in range of: ';
                    bonus = data['bonusBurstMin'] + ' - ' + data['bonusBurstMax'];
                    total = data['burstTotalMin'] + ' - ' + data['burstTotalMax'];
                } else {
                    bonusLabel = 'Bonus burst: ';
                    totalLabel = 'Total burst: ';
                    bonus = data['bonusBurstMax'];
                    total = data['burstTotalMax'];
                }
                $('label[for=bonusBurDh]').html(bonusLabel);
                $('label[for=totalBurDh]').html(totalLabel);
                if(data['bonusBurstDh']) {
                    $('#bonusBurDh').val(bonus);
                    $('#totalBurDh').val(total);
                }

                $('#bonusPoke').val(data['bonusPoke']);
                $('#totalPoke').val(data['totalPoke']);
                if(data['bonusPokeAe']) {
                    $('#bonusPokeAe').val(data['bonusPokeAe'] + ' (' + data['totalPokeAe'] + ' total)');
                }
                $('#bonusDps').val(data['bonusDps']);
                if(data['dmgAery']) {
                    $('#dmgAery').val(data['dmg'] + '( Aery dmg: ' + data['dmgRune'] + ')');
                }
                if(data['bonusMob']) {
                    $('#bonusMob').val(data['bonusMob'] + ' (' + data['totalMob'] + ' total)');
                    $('#bonusMobFig').val(data['bonusMobFig'] + ' (' + data['totalMobFig'] + ' total in fight)');
                }
                $('#totalUtil').val(data['totalUtil']);
                if(data['overUtil']) {
                    $('#overUtilDiv').removeClass('collapse');
                    $('#overUtil').val(data['overUtil']);
                } else if($('#overUtilDiv').hasClass('collapse')){
                    $('#overUtilDiv').addClass('collapse');
                    $('#overUtil').val(0);
                }

                $('#bonusGold').val(data['bonusGold']);

                $('#shield').val(data['shield']);
                if(data['bonusShield']) {
                    $('#bonusShield').val(data['bonusShield'] + ' (' + data['totalShield'] + ' total)');
                }

                if($('#role').val() != "" && $('#role').val() != "Enchanter") {
                    $('#baScaled').val(data['baScaled']);
                    $('#burstScaled').val(data['burstScaled']);
                    $('#scaled').removeClass('collapse');
                    $('#scaledLabel').removeClass('collapse');
                } else if(!$('#scaled').hasClass('collapse')) {
                    $('#scaled').addClass('collapse');
                    $('#scaledLabel').addClass('collapse');
                    $('#baScaled').val(0);
                    $('#burstScaled').val(0);
                }


            });
        }
    </script>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content bigger scroll-container">
        @include('flash::message')

        <div class="title m-b-md">
            MLS - Runes
        </div>
        <label for="myForm">Select champion:</label>

        <div>
            <button type="button" class="btn btn-white mode" id="dark">White mode</button>

            <select class="champSelect" id="mySelect">
                <option value="Custom">Custom</option>
                @foreach($champions as $champion)
                    <option value="{{ $champion->id }}">{{ $champion->name }}</option>
                @endforeach
            </select>

            <select class="champSelect collapse" id="roleSelect">
                <optgroup label="Custom values">
                    <option value="Custom">Custom</option>
                </optgroup>
                @foreach($roles as $role)
                    @php
                    $champs = \App\Champion::where('role', $role)->get()
                    @endphp
                    <optgroup label="{{ $role ?? 'Others' }}">
                        @foreach($champs as $champion)
                            <option value="{{ $champion->id }}">{{ $champion->name }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
            </select>
            <div>
                <input type="checkbox" id="checkChamps">
                <label for="checkChamps">Sort champions by role</label>
            </div>
        </div>
        <br>
        <div class="getBorder">
            <label>Base stats:</label>
            <form method="post" action="{{ route('rune') }}" id="myForm">
                <div class="inline-block">
                    <label for="role">Role</label>
                    <input type="text" maxlength="10" name="role" id="role">
                </div>
                <div class="inline-block">
                    <label for="burst">Burst</label>
                    <input type="number" min="0" max="100" step="10" name="burst" value="0"  id="burst"/>
                </div>
                <div class="inline-block">
                    <label for="poke">Poke</label>
                    <input type="number" min="0" max="100" step="10" name="poke" value="0" id="poke"/>
                </div>
                <div class="inline-block">
                    <label for="ba">Basic attacks</label>
                    <input type="number" min="0" max="100" step="10" name="ba" value="0" id="ba"/>
                </div>
                <div class="inline-block">
                    <label for="tank">Tank</label>
                    <input type="number" min="0" max="100" step="10" name="tank" value="0" id="tank"/>
                </div>
                <div class="inline-block">
                    <label for="resistance">Resistance</label>
                    <input type="number" min="0" max="1000" disabled name="resistance" value="0" id="resistance"/>
                </div>
                <div class="inline-block">
                    <label for="sustain">Sustain</label>
                    <input type="number" min="0" max="100" step="10" name="sustain" value="0" id="sustain"/>
                </div>
                <div class="inline-block">
                    <label for="utility">Utility</label>
                    <input type="number" min="0" max="100" step="10" name="utility" value="0" id="utility"/>
                </div>
                <div class="inline-block">
                    <label for="mobility">Mobility</label>
                    <input type="number" min="0" max="100" step="10" name="mobility" value="0" id="mobility"/>
                </div>
                <div class="inline-block">
                    <label for="difficulty">Difficulty</label>
                    <input type="number" min="0" max="100" step="10" name="difficulty" value="0" id="difficulty"/>
                </div>
                <br>

                <div class="inline-block">
                <label class="collapse" id="scaledLabel">Scaled stats</label>
                    <div class="collapse" id="scaled">
                        <label for="burstScaled">Burst</label>
                        <input type="text" disabled  id="burstScaled"/>

                        <label for="baScaled">Basic attacks</label>
                        <input type="text" value="0" id="baScaled"/>
                    </div>
                </div>

                <br>
                <br>
                {{--                        <li>--}}
                <div class="bigger2" id="timeDiv">
                    <label for="time">Time in fight (1 - 100)</label>
                    <input class="changeInput" type="range" min="1" max="100" value="1" step="1" name="time" id="time"/>
                    <span class="">1 second</span>
                </div>

                <br>

                <div class="bigger2 collapse" id="reachedDiv">
                    <label for="reached">Minute when carry reached 9k gold (1 - 70)</label>
                    <input class="changeInput" type="range" min="1" max="70" value="1" step="1" name="reached" id="reached"/>
                    <span class="">1 minute</span>
                    <br>
                    <br>

                </div>

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

                <div class="bigger2 collapse" id="shutdownDiv">
                    <label for="shutdown">Number of kills and assists (0 - 50)</label>
                    <input class="changeInput" type="range" min="0" max="50" value="0" step="1" name="shutdown" id="shutdown"/>
                    <span class="">0 shutdowns</span>
                    <br>
                    <br>

                </div>

                <div id="opponentDiv" class="collapse">
                    <label style="margin-right: 15px" for="opponentSelect">Select your enemy</label>
                    <select class="" id="opponentSelect" name="opponentSelect">
                        <option value="Custom">Custom</option>
                        @foreach($champions as $champion)
                            <option value="{{ $champion->id }}">{{ $champion->name }}</option>
                        @endforeach
                    </select>
                    <input type="checkbox" name="afOn" id="afOn">
                    <label for="afOn">Aftershock</label>

                    <br>
                    <label for="tankOpp">Tank</label>
                    <input type="number" min="0" max="100" step="10" value="0" name="tankOpp" id="tankOpp"/>
                    <label for="resistanceOpp">Resistance</label>
                    <input type="number" min="0" max="1000" readonly name="resistanceOpp" value="0" id="resistanceOpp"/>

                    <label for="utiOpp">Utility</label>
                    <input type="number" min="0" max="100" step="10" value="0" name="utiOpp" id="utiOpp"/>
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
                        <optgroup label="Sorcery">
                            <option value="comet">Arcane Comet</option>
                            <option value="aery">Summon Aery</option>
                            <option value="rush">Phase Rush</option>
                        </optgroup>
                        <optgroup label="Domination">
                            <option value="hob">Hail of Blades</option>
                            <option value="ele">Electrocute</option>
                            <option value="dh">Dark Harvest</option>
                        </optgroup>
                        <optgroup label="Resolve">
                            <option value="af">Aftershock</option>
                            <option value="gu">Guardian (Enchanters only)</option>
                        </optgroup>
                        <optgroup label="Inspiration">
                            <option value="gl">Glacial Augment</option>
                            <option value="klepto">Kleptomancy</option>
                        </optgroup>
                    </select>
                </div>
            </form>
            <br>
            <br>
        </div>
            <div class="bigger3">
                <div class="inline-container result">
                    <div class="inline collapse" id="dmgDiv">
                        <div class="inline-block">
                            <label for="dmg">Damage done:</label>
                            <input readonly disabled type="text" id="dmg" name="dmg"/>
                        </div>
                        <br>
                    </div>
                    <div class="inline collapse" id="healDiv">
                        <div class="inline-block">
                            <label for="heal">Healing done:</label>
                            <input readonly disabled type="text" id="heal" name="heal"/>
                        </div>
                        <br>
                    </div>
                </div>

                <div id="ffDiv" class="collapse">
                    <div class="inline-block">
                        <label for="base">Healing done outside fight:</label>
                        <input readonly disabled type="text" id="base" name="base"/>
                    </div>
                    <div class="inline-block">
                        <label for="fight">Healing done during fight:</label>
                        <input readonly disabled type="text" id="fight" name="fight"/>
                    </div>
                </div>
                <div class="collapse" id="afterDiv">
                    <div class="inline-block">
                        <label for="bonus">Bonus Resistance at initiation:</label>
                        <input readonly disabled type="text" id="bonus" name="bonus"/>
                    </div>
                    <div class="inline-block">
                        <label for="afterAll">Total bonus resistance:</label>
                        <input readonly disabled type="text" id="afterAll" name="afterAll"/>
                    </div>
                    <div class="inline collapse danger" id="overcappedDiv">
                        <div class="inline-block">
                            <label for="over">Limit overcapped by:</label>
                            <input class="danger-input" readonly disabled type="text" id="over" name="over"/>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="eleDiv">
                    <div class="inline-block">
                        <label for="bonusBur">Bonus Burst at initiation:</label>
                        <input readonly disabled type="text" id="bonusBur" name="bonusBur"/>
                    </div>
                    <div id="negateDiv" style="display: inline">
                        <div class="inline-block">
                            <label for="negate">Resistance negated:</label>
                            <input readonly disabled type="text" id="negate" value="0" name="negate"/>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="dhDiv">
                    <div class="inline-block">
                        <label for="bonusBurDh">Bonus Burst:</label>
                        <input readonly disabled type="text" id="bonusBurDh" name="bonusBurDh"/>
                    </div>
                    <div class="inline-block">
                        <label for="totalBurDh">Total burst:</label>
                        <input readonly disabled type="text" id="totalBurDh" value="0" name="totalBurDh"/>
                    </div>
                </div>
                <div class="collapse" id="cometDiv">
                    <div class="inline-block">
                        <label for="bonusPoke">Bonus Poke:</label>
                        <input readonly disabled type="text" id="bonusPoke" name="bonusPoke"/>
                    </div>
                    <div class="inline-block">
                        <label for="totalPoke">Total Poke:</label>
                        <input readonly disabled type="text" id="totalPoke" value="0" name="totalPoke"/>
                    </div>
                </div>
                <div class="collapse result" id="aeryDiv">
                    <div class="inline-block">
                        <label for="bonusPokeAe">Bonus Poke:</label>
                        <input readonly disabled type="text" id="bonusPokeAe" name="bonusPokeAe"/>
                    </div>
                    <div class="inline-block">
                        <label for="bonusDps">Bonus to DPS:</label>
                        <input readonly disabled type="text" id="bonusDps" value="0" name="bonusDps"/>
                    </div>
                    <div class="inline-block">
                        <label for="dmgAery">Damage dealt:</label>
                        <input readonly disabled type="text" id="dmgAery" value="0" name="dmgAery"/>
                    </div>
                </div>
                <div class="collapse" id="rushDiv">
                    <div class="inline-block">
                        <label for="bonusMob">Bonus Mobility:</label>
                        <input readonly disabled type="text" id="bonusMob" name="bonusMob"/>
                    </div>
                    <div class="inline-block">
                        <label for="bonusMobFig">Bonus Mobility in fight:</label>
                        <input readonly disabled type="text" id="bonusMobFig" value="0" name="bonusMobFig"/>
                    </div>
                </div>
                <div class="collapse" id="glDiv">
                    <div class="inline-block">
                        <label for="totalUtil">Total Utility:</label>
                        <input readonly disabled type="text" id="totalUtil" value="0" name="totalUtil"/>
                    </div>
                    <div class="inline collapse danger" id="overUtilDiv">
                        <div class="inline-block">
                            <label for="overUtil">Limit overcapped by:</label>
                            <input class="danger-input" readonly disabled type="text" id="overUtil" name="overUtil"/>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="kleptoDiv">
                    <div class="inline-block">
                        <label for="bonusGold">Bonus gold per poke(max 100/min):</label>
                        <input readonly disabled type="text" id="bonusGold" name="bonusGold"/>
                    </div>
                </div>
                <div class="collapse" id="shieldDiv">
                    <br>
                    <div class="inline-block">
                        <label for="shield">Shield when ally is damaged:</label>
                        <input readonly disabled type="text" id="shield" name="shield"/>
                    </div>
                    <div class="inline collapse" id="guardianDiv">
                        <div class="inline-block">
                            <label for="bonusShield">Bonus shield with guardian:</label>
                            <input readonly disabled type="text" id="bonusShield" name="bonusShield"/>
                        </div>
                        <br>
                    </div>
                </div>
            </div>

        <br>
    </div>
</div>
<script>
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
</script>
</body>
</html>
