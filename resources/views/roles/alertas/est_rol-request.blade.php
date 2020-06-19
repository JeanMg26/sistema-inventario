<style>
	.alert{
		margin: .5rem 0 0 0;
		padding: .2rem 0 .2rem .2rem;
		font-size: .75rem; 
      color: #e46a76;
	}
</style>


@if ($errors->get('est_rol'))
<div class="alert alert-danger" id="est_rol-error">
	@foreach ($errors->get('est_rol') as $x)
	{{ $x}}
	<br>
	@endforeach
</div>
@endif

