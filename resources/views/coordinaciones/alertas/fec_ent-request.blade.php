<style>
	.alert{
		margin: .5rem 0 0 0;
		padding: .2rem 0 .2rem .2rem;
		font-size: .8rem; 
      color: #e46a76;
	}
</style>


@if ($errors->get('fec_ent'))
<div class="alert alert-danger" id="fec_ent-error">
	@foreach ($errors->get('fec_ent') as $x)
	{{ $x}}
	<br>
	@endforeach
</div>
@endif

