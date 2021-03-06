@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			@include('alerts.success')
				<div class="col-md-10">
					<h1>Tengo</h1>
					<h3>Describe los materiales que deseas compartir con una nueva entrada</h3>
				</div>

				<div class="col-md-4">
					<a href="{{ route('tengo.create') }}" class="btn btn-lg btn-block btn-primary btn-h1-spacing glyphicon glyphicon-plus">Crear nueva entrada</a>
				</div>
			<div class="col-md-12">
			<table class="table">
				<thead>
					<tr>
						<th>Titulo</th>
						<th>Mensaje</th>
						<th>Categoria</th>
						<th>Creado El</th>
					</tr>
				</thead>
				<tbody>
				@foreach($teng as $tengo)
					{{-- @can('owner', $tengo) --}}
						<tr>
							<td><strong>{{ $tengo->title }}</strong></td>
							<td>{{ substr(strip_tags($tengo->body), 0, 50) }}{{ strlen(strip_tags($tengo->body)) > 50 ? "..." : "" }}</td>
							<td>{{ $tengo->categoria->name }}</td>
							<td>{{ date('M j, Y', strtotime($tengo->created_at)) }}</td>
							<td>
								@if(Auth::user()==$tengo->user)
								<div class="btn-group">
									{{ link_to_route('tengo.edit', $title = 'Editar', $parameter = $tengo, $attributes = ['class' => 'btn btn-primary btn-sm']) }}
									@endif
									{{ link_to_route('tengo.show', $title = 'Ver', $parameter = $tengo, $attributes = ['class' => 'btn btn-info btn-sm']) }}
								</div>
							</td>
						</tr>
					{{-- @endcan --}}
				@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-md-12">
			<div class="text-center">
				{!!	$teng->links();	!!}
			</div>
		</div>
		</div>


@endsection
