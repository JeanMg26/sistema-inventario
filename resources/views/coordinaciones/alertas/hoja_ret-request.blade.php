<style>
	.alert{
		margin: .5rem 0 0 0;
		padding: .2rem 0 .2rem .2rem;
		font-size: .8rem; 
      color: #e46a76;
	}
</style>


@if ($errors->get('hoja_ret'))
<div class="alert alert-danger" id="hoja_ret-error">
	@foreach ($errors->get('hoja_ret') as $x)
	{{ $x}}
	<br>
	@endforeach
</div>
@endif

