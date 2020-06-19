<style>
   .alert{
      margin: .5rem 0 0 0;
      padding: .2rem 0 .2rem .2rem;
      font-size: .75rem; 
      color: #e46a76;
   }
</style>


@if ($errors->get('nom_usu'))
<div class="alert alert-danger" id="nom_usu-error">
   @foreach ($errors->get('nom_usu') as $x)
   {{ $x}}
   <br>
   @endforeach
</div>
@endif