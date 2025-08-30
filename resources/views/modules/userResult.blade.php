@extends('index.sidebar')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h1 class="m-0">{{\App\Models\UserResultProtokol::query()->where('user_id', $userId)->value('user')}}</h1>
            </div>
        </div>
    </div>

    <section class="content">
        <!-- Modal -->
        <form role="form" method="post" action="" enctype="multipart/form-data">
            <meta name="csrf-token" content="{{ csrf_token()}}">
            @foreach($normative as $name => $result)
                <label for="{{$name}}">{{$name}}</label>
                <input type="text" class="form-control" id="{{$name}}" name="{{$name}}"
                       value="{{$result}}" autocomplete="off"
                       data-protocol="{{$protocol_id}}"
                       data-user="{{$userId}}"
                       onchange="dataEnter(this)">
            @endforeach
        </form>
    </section>

    <script>
        function dataEnter(data){
            //console.log($(data).data('protocol'))
            let ar = {
                'user' : $(data).data('user'),
                'protocol' : $(data).data('protocol'),
                'normative' : data.name,
                'value' : data.value
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{ route('user.enter.data') }}',
                dataType: 'json',
                data: ar,
                success: function (data) {
                    console.log(data)
                },
            });
        }
    </script>
@endsection
