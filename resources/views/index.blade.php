<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('58460d027b162c9a6ecc', {
            cluster: 'us2'
        });

        var channel = pusher.subscribe('students');
        channel.bind('App\\Events\\StoreStudentEvent', function(data) {
            alert(JSON.stringify(data));
            location.reload();
        });

    </script>

    <title>Students</title>
</head>
<body>
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-left">
                <h2>Students List</h2>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Degree</th>
            <th width="280px">User</th>
        </tr>
        <?php $i=1;?>
        @foreach ($students as $student)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $student->full_name }}</td>
            <td>{{ $student->degree }}</td>
            <td>
                {{ $student->user->full_name }}
                @if ($student->user->is_admin == 1)
                {{ "Admin" }}
                @else
                {{ "Isn't Admin" }}
                @endif
            </td>
        </tr>
        @endforeach

    </table>
    {{ $students->links() }}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
