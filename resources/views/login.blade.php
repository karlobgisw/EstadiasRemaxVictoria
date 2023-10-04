<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
  <header>
    @include('navLogin')
  </header>
  <div class="center">
    <div class="imagen">
      <img src="{{ asset('images\globo.png') }}" alt="">
    </div>
    <form method="post" action="{{ route('login') }}">
      @csrf
      <div class="txt_field">
        <input type="text" name="sir" required>
        <label>Nombre de usuario</label>
      </div>
      <div class="txt_field">
        <input type="password" name="password" required>
        <label>Contraseña</label>
      </div>
      <div class="pass">¿Olvido su contraseña?</div>
      <input type="submit" value="Iniciar Sesion">
      <div class="card-body">
        @if ($errors->any())
          <div class="alert alert-danger">
              @foreach ($errors->all() as $error)
                <center><p>{{ $error }}</p></center>
                  @endforeach
          </div>
                    @endif
                    
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
</body>

</html>
