<style>
	.alert{
		margin: .5rem 0 0 0;
		padding: .2rem 0 .2rem .2rem;
		font-size: .8rem; 
      color: #e46a76;
	}
</style>


@if ($errors->get('cel_emp'))
<div class="alert alert-danger"  id="cel_emp-error">
	@foreach ($errors->get('cel_emp') as $x)
	{{ $x}}
	<br>
	@endforeach
</div>
@endif

