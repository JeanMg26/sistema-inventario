@extends('main')

@section('titulo')
  Gráficos
@endsection

@section('contenido')

<!-- Breadcrumbs-->
<ol class="breadcrumb">
	<li class="breadcrumb-item">
		<a href="{{ url('/') }}"><i class="fas fa-home-lg-alt mr-1"></i></i>Inicio</a>
	</li>
	<li class="breadcrumb-item">
		<a href="{{ route('supervisiones.index') }}"><i class="fad fa-laptop mr-1"></i>Supervisión</a>
	</li>
	<li class="breadcrumb-item active" aria-current="page"><i class="fad fa-chart-bar mr-1"></i>Gráficos</li>
</ol>



<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">

				<!-- ************** TABS ************************ -->
				<section id="tabs">
					<div class="row">
						<div class="col-12">
							<nav>
								<div class="nav nav-tabs nav-fill" id="tab">
									<a class="nav-item nav-link active" data-toggle="tab" href="#total_chart">BIENES TOTALES</a>
									<a class="nav-item nav-link" data-toggle="tab" href="#equipo_chart">BIENES POR EQUIPO</a>
								</div>
							</nav>

							<div class="tab-content pt-3">
								{{-- ******************* TAB CANTIDAD TOTAL DE BIENES **************** --}}
								<div class="tab-pane active" id="total_chart" >

									<div class="row d-flex justify-content-center mt-3">
										<div class="col-12 col-sm-8 col-md-6 col-lg-3 text-center" id="btn-year_total">
											{!! Form::select('year_total', ['' => ''] + $year_total, null, ['class' => 'form-control form-control-sm', 'onpaste' => 'return false', 'id' => 'year_total']) !!}
										</div>
									</div>

									<div class="row">
										<div class="col-12">
											<div class="row d-flex justify-content-center">
												<div class="col-12 col-md-10 text-center" id="chart_wrap">
													<p class="mb-0" id="tchart_total"></p>
													<div id="tchart"></div>
												</div>
											</div>
										</div>
									</div>



								</div>

								{{-- ******************* TAB CANTIDAD BIENES POR EQUIPO **************** --}}
								<div class="tab-pane " id="equipo_chart">

									<div class="row d-flex justify-content-center my-3">
										<div class="col-12 col-sm-8 col-md-6 col-lg-3 text-center" id="btn-year">
											{!! Form::select('year', ['' => ''] + $year, null, ['class' => 'form-control form-control-sm', 'onpaste' => 'return false', 'id' => 'year']) !!}
										</div>
									</div>

									<div class="row">

										<div class="col-12">
											{{-- ******** FILTRAR POR FECHAS ************ --}}
											<div class="card mb-3 border-danger">
												<div class="card-header text-white font-weight-bold bg-danger collapsed" data-toggle="collapse" data-target="#filtro_fechas">Filtrar por Fechas
													<a class="float-right" data-toggle="collapse" data-target="#filtro_fechas" class="collapsed">
														<em class="fa fa-plus"></em>
													</a>
												</div>
												<div class="collapse show" id="filtro_fechas" style="">
													<div class="card-body row d-flex justify-content-center">
														<div class="col-12 col-lg-12 col-xl-11">
															<div class="row">
																<div class="col-12 col-sm-6 col-lg-4 pr-sm-0">
																	<div class="row mx-1">
																		<div class="input-group">
																			{!! Form::text('fecha_desde', null, ['class' => 'form-control form-control-sm text-center' , 'id' => 'fecha_desde', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'DESDE']) !!}
																			<div class="input-group-append">
																				<span class="input-group-text"><i class="fal fa-calendar-alt"></i>
																				</span>
																			</div>
																		</div>

																	</div>
																</div>

																<div class="col-12 col-sm-6 col-lg-4 mt-1 mt-sm-0">
																	<div class="row mx-1">
																		<div class="input-group">
																			{!! Form::text('fecha_hasta', null, ['class' => 'form-control form-control-sm text-center' , 'id' => 'fecha_hasta', 'autocomplete' => 'off', 'readonly', 'placeholder' => 'HASTA']) !!}
																			<div class="input-group-append">
																				<span class="input-group-text"><i class="fal fa-calendar-alt"></i>
																				</span>
																			</div>
																		</div>
																	</div>
																</div>

																<div class="col-12 col-lg-4 text-center mt-3 mt-lg-0">
																	{!! Form::button('<i class="far fa-filter mr-2"></i>Filtrar', ['class'=>'btn btn-info btn-sm px-4 mr-2', 'type' => 'button', 'id' => 'filtrar']) !!}
																	{!! Form::button('<i class="far fa-broom mr-2"></i>Reiniciar', ['class'=>'btn btn-secondary btn-sm px-3', 'type' => 'button', 'id' => 'reiniciar']) !!}
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>



										<div class="col-12">
											<div class="row d-flex justify-content-center">
												<div class="col-12 col-md-10 text-center" id="chart_wrap">
													<p class="mb-0" id="echart_total"></p>													
													<div id="echart"></div>
												</div>
											</div>
										</div>
									</div>


								</div>
							</div>
						</div>
					</section>
					<!-- **************** /TABS ********************** -->
				</div>
			</div>
		</div>
	</div>
</div>




@endsection



@section('script')

<script src="{{ asset('scripts/script_google_graficos.js') }}"></script>

@endsection