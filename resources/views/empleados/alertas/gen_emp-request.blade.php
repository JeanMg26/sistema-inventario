<style>
	.alert{
		margin: .5rem 0 0 0;
		padding: .2rem 0 .2rem .2rem;
		font-size: .8rem; 
      color: #e46a76;
	}
</style>


@if ($errors->get('gen_emp'))
<div class="alert alert-danger" id="gen_emp-error">
	@foreach ($errors->get('gen_emp') as $x)
	{{ $x}}
	<br>
	@endforeach
</div>
@endif

