@php
    $items = ['Egresados' => '#', 'Empleadores' => '#', 'Reportes' => '#', 'Usuarios' => '#'];
@endphp
<ul class="nav flex-column" id="side_menu">
  <li class="nav-item p-3">
    <img src="..." class="img-thumbnail" alt="...">
  </li>
    @foreach ($items as $index => $item)
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="{{ $item }}">{{ $index }}</a>
    </li>
    @endforeach
</ul>
