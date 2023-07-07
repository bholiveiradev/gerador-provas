<html>
<head>
    <style>
        p {
            margin: .2rem 0;
        }
        table {
            width: 100%;
        }
    </style>
</head>
<body>
    <p><span style="font-family: Arial, Helvetica, sans-serif;">AQUI PODEMOS COLOCAR ALGUMA
            INFORMA&Ccedil;&Atilde;O</span></p>
    <p><span style="font-family: Arial, Helvetica, sans-serif;">INFORMA&Ccedil;&Otilde;ES DA PROVA</span></p>
    <p><span style="font-family: Arial, Helvetica, sans-serif;">INFORMA&Ccedil;&Otilde;ES DO PROFESSOR</span></p>
    <p><span
            style="background-color: #000000; color: #ffffff; display: block; padding: 5px; text-align: center; text-transform: uppercase; font-family: Arial, Helvetica, sans-serif;">PROFESSOR
            (A) DE {{ $test->subject->name }}</span></p>
    {!! $test->infos !!}

    @foreach ($test->questions as $question)
    <hr>
    {!! $question->additional_text !!}
    <ol>
        <li style="font-family: Arial, Helvetica, sans-serif;">
            <p><span style="font-family: Arial, Helvetica, sans-serif;">{{ $question->question }}</span></p>
            <ol style="list-style-type: lower-alpha;">
                @foreach($question->answers as $answer)
                <li style="font-family: Arial, Helvetica, sans-serif;">
                    <p>{{ $answer->answer }}</p>
                </li>
                @endforeach

            </ol>
        </li>
        <p style="font-family: Arial, Helvetica, sans-serif;"><b>Resposta: </b>{{ $question->answers()->whereIsCorrect(true)->first()->answer }}</p>
    </ol>
    @endforeach
</body>

</html>
