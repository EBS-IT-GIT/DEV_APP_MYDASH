@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">
    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed', 
    'top-nav' => 'layout-top-nav'
    
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo" style="margin-top:0px;">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                 <span class="logo-mini" id="logo" title="Mydashboard Painel"><strong>My</strong><!--{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}--></span> 
                <!-- logo for regular state and mobile devices -->

                <span class="logo-lg" ><strong>Mydashboard</strong> Painel</span>

            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation" style="height:50px;">
                <!-- Sidebar toggle button-->
                <button type="button" id="push" data-toggle="push-menu" onclick="javascript: location.href= '#'"  class="sidebar-toggle"  role="button" style="border-color:transparent; height:50px;">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </button>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <input type="hidden" name="cliente-filter" id="cliente-filter" value="{{\Session::get('idcliente')}}">
                    <input type="hidden" name="instancia-filter" id="instancia-filter" value="{{\Session::get('idinstancia')}}">
                    <ul class="nav navbar-nav">
          <li>
                        <!--form class="form-inline" action="index.html" method="post"-->
                        <div class="form-inline" style="float:right;">
                          <div class="input-group" style="margin-top:10px;">
                            <input type="text" id="numerochamado" value="" placeholder="pesquisar chamado" class="form-control input-sm" style=" width:200px;" />
                            <span class="input-group-btn">
                              <button type="button" id="pesquisarchamado" class="btn btn-sm btn-default">
                                <i class="fa fa-search"></i>
                              </button>
                            </span>
                          </div>
                        </div>
                        <!--/form-->
                      </li>
                          <li>
                            @if(config('adminlte.logout_method') == 'GET' || !config('adminlte.logout_method') && version_compare(\Illuminate\Foundation\Application::VERSION, '5.3.0', '<'))
                                <a href="{{ url(config('adminlte.logout_url', 'auth/logout')) }}">
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                            @else
                                <a href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                >
                                    <i class="fa fa-fw fa-power-off"></i> {{ trans('adminlte::adminlte.log_out') }}
                                </a>
                                <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                                    @if(config('adminlte.logout_method'))
                                        {{ method_field(config('adminlte.logout_method')) }}
                                    @endif
                                    {{ csrf_field() }}
                                </form>
                            @endif
                        </li>
                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>

        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar" id="push-menu">

                <div class="user-panel">
                  <div class="pull-left image">
                    <img src="{{ asset('/') }}user.png" class="img-circle" alt="User Image">
                  </div>
                  <div class="pull-left info">
                    <p>{{ Session::get('user')['login'] }} </p>
                    @if(isset(Session::get('user')['mail']))
                    <sub> {{ Session::get('user')['mail'] }}</sub>
                    @endif
                  </div>
                </div>
               <style>
               
               /* .menu ul ul{
                 display:none !important;
               } */
               /* .menu ul li:hover > ul{
                 display:block !important;
               } */
               
               </style>
                <!-- Sidebar Menu -->
                      <!-- Sidebar Menu -->
                    <nav class="menu" >
                    <ul class="sidebar-menu" data-widget="tree">
                    {{-- @each('adminlte::partials.menu-item', $adminlte->menu(), 'item') --}}
                    @foreach(\App\Menu::listarMenu() as $item)
                    @if ($item->menu_type == 0)
                      <li class="header">{{ $item->title }}</li>

                    @elseif ($item->menu_type == 1)
                      @if($item->id == 1)
                        <li><a href="/"  title="P??gina Inicial" ><i class="fa fa-home"></i><span>P??gina Inicial</span></a></li>
                        
                        
                        <li class="treeview">
                        <a id="proj"href="#" title="Projetos"><i class="fa fa-folder"></i> <span title="Projetos">Projetos</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>


                        <!-- submenu -->
                        <ul class="treeview-menu" >
                        <li><a href="#">
                        <input class="inputsm" style="color:#444444;height:20px;" id="tableText" type="text"/> <span><i class="fa fa-search"></i></span></a></li>

                          {!! \App\Menu::submenuProjects() !!}

                          </ul>
                          </li><!-- submenu -->

                        <li><a href="/painel" title="Painel de controle"><i class=" fa fa-dashboard"></i> <span>Painel de controle</span></a>
                      @endif
                      @if($item->id == 3)
                        <li><a href="/reports" title="Relat??rios"> <i class="fa fa-list-alt"></i> <span >Relat??rios</span></a>
                        <li><a href="/backlogs" title="Backlogs"> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i><span>Backlogs</span></a>

                      @endif
                      @if($item->id == 7)
                        <li ><a title="Log de Atividades" href="/logs"><i class="fa fa-tasks"></i> <span>Log de Atividades</span></a>
                      @endif
                    @endif
                    @endforeach
                </ul>

                
                </nav>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif
  
                
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" >
        <div class="box" id="box-contador" style="display: none;left: 50%;margin-left: -175px; width:375px; margin-bottom:0px">
                        <div class="box-body" style="text-align:center;">      
                             Cron??metro Chamado N?? <b id="contador_taskid_ativo">@if(isset($contador[0])){{ $contador[0]->task_id }}@endif</b>
                             <span id="contador_timer" class="btn btn-xs btn-danger">00:00</span>
                            <button type="button" class="btn btn-sm btn-success" id="btn-chamado">Acessar Chamado</button>
                          </div>

                        </div>
                     
                     
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

        <!-- task detail -->
        <div class="modal fade" id="modal-detail" style="display: none;">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">??</span></button>
                  <h4 class="modal-title"><i class="fa fa-list"></i>
                  <span id="title-detail"></span></h4>
                  <div id="message-modal-detail"></div>
              </div>
                <div class="modal-body" id="content-detail">

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-door"></i> Fechar</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
          <!-- /.modal-dialog -->
        </div>

        <!-- cronometro apontamento -->
        <div class="modal fade" id="modal-cronometro" style="display: none;">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">??</span></button>
                  <h4 class="modal-title"><i class="fa fa-list"></i>
                  <span id="title-cronometro">Cron??metro Apontamento</span></h4>
                  <div id="message-modal-contador"></div>

                  <span id="contador_horas" class="btn btn-lg btn-danger pull-right">00:00</span>
              </div>
                <div class="modal-body" style="margin-bottom:30px;" id="content-cronometro">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="notes_contador">Descrever o atendimento <span class="text-red">*</span></label>
                          <input type="hidden" id="contadorid" value="@if(isset($contador[0])){{ $contador[0]->id }}@endif" />
                          <input type="hidden" id="taskid_contador" value="@if(isset($contador[0])){{ $contador[0]->task_id }}@endif" />
                          <textarea class="form-control input-sm" name="notes_contador" id="notes_contador" rows="3" cols="80" ></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="chamado_contador">Chamado <span class="text-red">*</span></label>
                          <input type="text" name="chamado_contador" id="chamado_contador" value="@if(isset($contador[0])){{ $contador[0]->task_id }}@endif"  class="form-control input-sm" style="width:90px;" readonly />
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="spent_on_contador">Data <span class="text-red">*</span></label>
                          <input type="text" name="spent_on_contador" id="spent_on_contador" value="@if(isset($contador[0])){{ $contador[0]->date_started }}@endif" placeholder="dd/mm/aaaa" class="form-control input-sm calcular_novo" style="width:90px;" disabled="disabled" />
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="hora_entrada_trabalho_contador">In??cio <span class="text-red">*</span></label>
                          <input type="text" name="hora_entrada_trabalho_contador" id="hora_entrada_trabalho_contador" value="@if(isset($contador[0])){{ $contador[0]->hora_inicio }}@endif" placeholder="00:00" class="form-control input-sm calcular_novo" style="width:90px;" disabled="disabled">
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="hora_saida_trabalho_contador">T??rmino <span class="text-red">*</span></label>
                          <input type="text" name="hora_saida_trabalho_contador" id="hora_saida_trabalho_contador" value="@if(isset($contador[0])){{ $contador[0]->finished_at }}@endif" placeholder="00:00" class="form-control input-sm calcular_novo" style="width:90px;" disabled="disabled">
                        </div>
                      </div>

                      <div class="col-md-2" style="width: 151px;"> 
                        <div class="form-group">
                          <label for="horas_contador">Horas <span class="text-red">*</span></label>
                          <input type="text" name="horas_contador" id="horas_contador" value="" placeholder="0.00" class="form-control input-sm" readonly style="width:90px;">
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="atividade_contador">Atividade <span class="text-red">*</span></label>
                          <select class="form-control input-sm" name="atividade_contador" id="atividade_contador">
                            @foreach ($activities as $ativ)
                              <option value="{{ $ativ['id'] }}">{{ $ativ['name'] }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-2">
                        <div class="form-group" id="help_tipohora" >
                          <label for="tipo_hora_contador">Tipo Hora <span class="text-red">*</span></label>
                            <select class="form-control input-sm" name="tipo_hora_contador" id="tipo_hora_contador">
                              <option value="Normal">Normal</option>
                              <option value="Extra">Extra</option>
                            </select>
                        </div>
                      </div>

                    </div>

                    <div class="col-md-12">
                      <label><span class="text-red">*</span> Campos obrigat??rios</label>
                      <label id="alerta_horario" class="pull-right"></label>
                   </div>


                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-warning" id="btn-parar-contador"><i class="fa fa-stop"></i> Parar</button>
                  <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-door"></i> Fechar</button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
          <!-- /.modal-dialog -->
        </div>

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <img src="{{ asset('/') }}logo-rodape.png" width="93" height="23" />
            </div>
            <strong>Copyright ?? {{ date('Y') }} <a href="http://www.ebs-it.services/">EBS-IT</a>.</strong> All rights reserved. <b>Version</b> 1.0.0
        </footer>
        http://www.ebs-it.services/
    <!-- ./wrapper -->
</div>
@stop


@section('adminlte_js')
<script type="text/javascript" src="{{asset('list-search/jquery.listSearch.min.js')}}"></script>

<script> 

    $(function(){
    $('#buscar').listSearch('#tableText');
    });

    var i = 0;
    $(document).on('expanded.pushMenu', function (e) {
      i = i + 1;
    });
    $(document).on('collapsed.pushMenu', function (e) {
      i = i + 1;
    });
    $(document).on('click', '#proj', function (e) {     
       i = i%2;
      if(i == 0){
        $('[data-toggle="push-menu"]').pushMenu('toggle');
      }

  });
      
    $.extend( true, $.fn.dataTable.defaults, {
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : false,
        'pageLength'  : 10,
        'autoWidth'   : true
        @if(\Session::get('locale', Config::get('app.locale'))=='pt-br')
        ,'language': {
          url: '{{ asset('/')}}js/Portuguese-Brasil.json'
        }
        @endif
    } );

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var optEasy = {
      url : function(param){
        return '{{ URL::to('/pesquisar')}}/'+param;
      },
      getValue: 'id',
      list: {
        onClickEvent: function() {
          var value = $("#numerochamado").getSelectedItemData().id;
          var url = "{{ URL::to('/taskreport')}}/" + value;
          $("<a>").attr("href", url).attr("target", "_blank")[0].click();
        }
      },
      template: {
        type: "custom",
        method: function(value, item) {
          return "<br /><b>"+ item.id +"</b><br />" + item.subject;
        }
      },
      requestDelay: 100
    }
    $('#numerochamado').easyAutocomplete(optEasy);

    /*
    ** Cron??metro
    */
    @if(isset($contador[0]))
    localStorage.setItem('contador', 1);
    
    var custom_toolbar = {
      // Define the toolbar groups as it is a more accessible solution.
      toolbarGroups: [{
        "name": "basicstyles",
        "groups": ["basicstyles"]
      },
        {
          "name": "links",
          "groups": ["links"]
        },
        {
          "name": "paragraph",
          "groups": ["list", "blocks"]
        },
        {
          "name": "document",
          "groups": ["mode"]
        },
       
        {
          "name": "styles",
          "groups": ["styles"]
        },
        {
          "name": "about",
          "groups": ["about"]
        }
      ],
      // Remove the redundant buttons from toolbar groups defined above.
      removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar',
      disableNativeSpellChecker: false,
      

    };

  var notes_contador_mark = new SimpleMDE({ element: $("#notes_contador")[0],
  toolbar: ["bold", "italic", "heading", "|", "quote","unordered-list","ordered-list","link","image",	"preview"],	spellChecker: false,});


    var timer;
    var startDate = new Date('{{ $contador[0]->started_at }}');

    timer = setInterval(function() {
      timeBetweenDates(startDate);
    }, 1000);

    function timeBetweenDates(startDate) {
      var now = new Date();
      var difference =  now.getTime() - startDate.getTime();
      var secondsInADay = 60 * 60 * 1000 * 24,
          secondsInAHour = 60 * 60 * 1000;

      var totalHoras = (difference / (1000 * 60 * 60));

      days = Math.floor(difference / (secondsInADay) * 1);
      hours = Math.floor((difference % (secondsInADay)) / (secondsInAHour) * 1);
      mins = Math.floor(((difference % (secondsInADay)) % (secondsInAHour)) / (60 * 1000) * 1);
      secs = Math.floor((((difference % (secondsInADay)) % (secondsInAHour)) % (60 * 1000)) / 1000 * 1);

      $("#contador_timer").text(days+'d:'+hours+':'+mins+':'+secs);
      $("#contador_horas").text(days+'d:'+hours+':'+mins+':'+secs);
      $("#hora_saida_trabalho_contador").val(+now.getHours()+':'+now.getMinutes()+':'+now.getSeconds());
      $("#horas_contador").val(totalHoras.toFixed(2));

      //verificar se precisa acrescentar um zero na mascara
        horas = now.getHours()
        minutos = now.getMinutes();
        if(horas>=0 && horas<10){
            $("#hora_saida_trabalho_contador").val('0'+now.getHours()+':'+now.getMinutes()+':'+now.getSeconds());
        }
        if(minutos>=0 && minutos<10){
            $("#hora_saida_trabalho_contador").val(now.getHours()+':'+'0'+now.getMinutes()+':'+now.getSeconds());
        }
        if((horas>=0 && horas<10) && (minutos>=0 && minutos<10)){
            $("#hora_saida_trabalho_contador").val('0'+now.getHours()+':'+'0'+now.getMinutes()+':'+now.getSeconds());
        }

    }
    @else
    localStorage.setItem('contador', 0);
    @endif


    checar = setInterval(function() {
      cont = localStorage.getItem('contador');
      switch (cont) {
        case '0':
          $('#box-contador').hide();
            break;
        case '1':
          el = $('#contador_taskid_ativo').text();

          if( el ){
            $('#box-contador').show();

          }else{
            clearInterval(checar);
            window.location.reload(true);
          }
            break;
          case'3':
              $('#box-contador').hide();
              clearInterval(checar);
              window.location.reload(true);
              break;
              //atualizar a p??gina taskreport quando o chamado for capturado
          case'4':
              clearInterval(checar);
              window.location.reload(true);
              localStorage.setItem('sla', 3);
              break;
      }
    }, 1000);

    //iniciar contador
    $(document).on('click', '#btn-iniciar-contador', function (e) {
            $('#btn-iniciar-contador').attr('disabled', false);
            // if (confirm('Iniciar o Contador no chamado ' + $('#edit_task_id').val() + '?')) {
              Swal.fire({
                  title: 'Iniciar o Contador no chamado ' + $('#edit_task_id').val() + '?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Sim'
                }).then((result) => {
                  if (result.isConfirmed) {
                   
                var taskid = $('#edit_task_id').val();
                var data = 'taskid=' + taskid;

                $.ajax({
                    url: '{{ URL::to('/iniciarcontador')}}',
                    data: data,
                    type: 'POST',
                    success: function (data) {
                        localStorage.setItem('contador', 2); //iniciar
                        location.reload(0);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                      Swal.fire({
                            title: 'Error!',
                            html: errorThrown,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });            
                        // $('#message-modal-contador').show().html('<div class="callout callout-danger"><h4>Status ' + textStatus + '!</h4><p>' + errorThrown + '</p></div>').delay(1500).hide(6000);
                    }
                });
              }
            })
        });

    $(document).on('click', '#btn-chamado', function(e) {
        $('#btn-chamado').attr('disabled',false);
    var taskid =  $('#taskid_contador').val();
    $("<a>").attr("href","{{ URL::to('/taskreport')}}/" + taskid).attr("target", "_blank")[0].click();

    });
    /*
    ** Fun????o de Para o Cron??metro e Inserir apontamento
    */
//

    $(document).on('click', '#btn-parar-contador', function(e){
        $('#btn-parar-contador').attr('disabled', false);

      var taskid = $('#taskid_contador').val();
      var contadorid = $('#contadorid').val();
      var notes = notes_contador_mark.value();
      
      // notes = notes.replace(/<.*?>/g, '');
      // notes = encodeURIComponent(notes.replace(/(\r\n|\n|\r)/gm, "") );
      var atividades = notes;
      var spent_on = $('#spent_on_contador').val();
      var hours = $('#horas_contador').val();
      var atividade = $('#atividade_contador').val();
      var hora_entrada_trabalho = $('#hora_entrada_trabalho_contador').val();
      var hora_saida_trabalho = $('#hora_saida_trabalho_contador').val();
      var tipo_hora = $('#tipo_hora_contador').val();
      //valida????o

            if (!notes) {
              Swal.fire({
                            title: 'Error!',
                            html: 'Campo coment??rio precisa ser preenchido!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });    
                return false;
            }

            if (taskid && notes && hours && atividades) {
                //contador = 2 finaliza o corn??metro e insere o apontamento
                var data = 'taskid=' + taskid +
                    '&contadorid=' + contadorid +
                    '&contador=2' +
                    '&spent_on=' + spent_on +
                    '&hours=' + hours +
                    '&notes=' + notes +
                    '&atividades=' + atividades +
                    '&activity=' + atividade +
                    '&hora_entrada_trabalho=' + hora_entrada_trabalho +
                    '&hora_saida_trabalho=' + hora_saida_trabalho +
                    '&tipo_hora=' + tipo_hora;

                $.ajax({
                    url: '{{ URL::to('/savenewtime')}}',
                    data: data,
                    type: 'POST',
                    async: false,
                    success: function (data) {
                      // var salvar = confirm("Deseja Salvar o Chamado?");
                      Swal.fire({
                      title: 'Deseja Salvar o Chamado?',
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Sim'
                    }).then((result) => {
                      if (result.isConfirmed) {
                        $('#btn-save-task').trigger('click');
                      }
                      else{
                        Swal.fire({
                            title: 'Success!',
                            html: 'Dados Atualizados Corretamente',
                            icon: 'success',
                            confirmButtonText: 'OK'
                            });    
                      }
                      location.reload(0);
                      localStorage.setItem('contador', 3);

                    })
                        //limpa o formul??rio de Novo Apontamento
                        // CKEDITOR.instances['notes_contador'].setData('');
                        // $('#chamado_contador').val('');
                        // $('#spent_on_contador').val('');
                        // $('#hora_entrada_trabalho_contador').val('');
                        // $('#hora_saida_trabalho_contador').val('');
                        // $('#horas_contador').val('');
                        // $('#atividades_contador').val('');
                        // $('#box-contador').html('');
                        // $('#modal-cronometro').modal('hide');
                      
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                      Swal.fire({
                            title: 'Error!',
                            html: errorThrown,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });        
                        // $('#message-modal-contador').show().html('<div class="callout callout-danger"><h4>Status ' + textStatus + '!</h4><p>' + errorThrown + '</p></div>').delay(1500).hide(6000);
                    }

                });

            }

    else {
                var campos = '';
                if (!notes) campos += '  '
                Swal.fire({
                            title: 'Error!',
                            html: 'Campos obrigat??rios!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });        
                // $('#message-modal.contador').show().html('<div class="callout callout-danger"><h4>Campos obrigat??rios!</h4></div>').delay(1500).hide(6000);
            }



       });

    //bot??o para add um novo apontamento    
    
    $(document).on('click', '#show-apontamento', function(e){

      $('#apontamento-bloco').show();
      $('#hide-apontamento').show();
      $('#show-apontamento').hide();

    });

    //bit??o para cancelar novo apontamento
    $(document).on('click', '#hide-apontamento', function(e){

    $('#apontamento-bloco').hide();
    $('#hide-apontamento').hide();
    $('#show-apontamento').show();
    $("#hora_entrada_trabalho").val("");
    $("#hora_saida_almoco").val("");
    $("#hora_retorno_almoco").val("");
    $("#hora_saida_trabalho").val("");
    $("#notes").val("");
    $("#horas").val("");



    });
    /*
    ** Fun????o de inser????o de Novo Apontamento
    */
    $(document).on('click', '#btn-save-newtime', function(e){
      $('#btn-save-newtime').attr('disabled',false);

      var taskid = $('#taskid_edit').val();
      var projectid = $('#project_edit').val();
      var notes = $('#notes').val();
      
      // notes = encodeURIComponent(notes.replace(/(\r\n|\n|\r)/gm, "") );
      var spent_on = $('#spent_on').val();
      var hours = $('#horas').val();
      
      // var atividades = $('#atividades').val();
      // atividades = encodeURIComponent(atividades.replace(/(\r\n|\n|\r)/gm, "") );
      var atividade = $('#atividade').val();
      var hora_entrada_trabalho = $('#hora_entrada_trabalho').val();
      var hora_saida_almoco = $('#hora_saida_almoco').val();
      var hora_retorno_almoco = $('#hora_retorno_almoco').val();
      var hora_saida_trabalho = $('#hora_saida_trabalho').val();
      var tipo_hora = $('#tipo_hora').val();
      
      //valida????o
        if (!notes||!spent_on||!hora_entrada_trabalho||!hora_saida_trabalho) {
            Swal.fire({
                            title: 'Error!',
                            html: 'Campo(s) obrigat??rio(s) n??o preenchido(s)!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });  
            return false;
        }
        

      if(taskid && projectid && notes && hours && hora_entrada_trabalho && hora_saida_trabalho)
      {

        if (hora_entrada_trabalho == "00:00") {
          Swal.fire({
                            title: 'Error!',
                            html: 'Campo "Inicio" n??o pode receber zero!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });  

            return false;
        }
        if (hora_saida_trabalho == "00:00") {
          Swal.fire({
                            title: 'Error!',
                            html: 'Campo "T??rmino" n??o pode receber zero!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });  

            return false;
        }
        if(hours > 24.0){
        Swal.fire({
                            title: 'Error!',
                            html: 'O registro n??o deve ser maior que 24 horas!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                            }); 
                            return false; 

      }
        var data = 'taskid='+taskid+
        '&contador=0'+
        '&projectid='+projectid+
        '&spent_on='+spent_on+
        '&hours='+hours+
        '&notes='+notes+
        '&activity='+atividade+
        '&hora_entrada_trabalho='+hora_entrada_trabalho+
        '&hora_saida_almoco='+hora_saida_almoco+
        '&hora_retorno_almoco='+hora_retorno_almoco+
        '&hora_saida_trabalho='+hora_saida_trabalho+
        '&tipo_hora='+tipo_hora;

        $.ajax({
          url : '{{ URL::to('/savenewtime')}}',
          data: data,
          type: 'POST',
          success: function(data){
            Swal.fire({
                            title: 'Success!',
                            html: 'Dados Atualizados Corretamente!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                            });   
            $('#aba-apontamentos').click();  

            //limpa o formul??rio de Novo Apontamento
            $('#notes').val('');
            $('#horas').val('');
            $('#hora_entrada_trabalho').val('');
            $('#hora_saida_almoco').val('');
            $('#hora_retorno_almoco').val('');
            $('#hora_saida_trabalho').val('');
          },
          error: function(xhr, textStatus, errorThrown){
            Swal.fire({
                            title: 'Error!',
                            html: xhr.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });     
            // $('#message-modal-detail').show().html('<div class="callout callout-danger"><h4>Status '+textStatus+'!</h4><p>'+errorThrown+'</p></div>').delay(1500).hide(6000);
          }
        });
      }else{
        var campos = '';
        if(!notes) campos += '  '
        Swal.fire({
                            title: 'Error!',
                            html: 'Campo(s) obrigat??rio(s) n??o preenchido(s)!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });     
        // $('#message-modal.detail').show().html('<div class="callout callout-danger"><h4>Campos obrigat??rios!</h4></div>').delay(1500).hide(6000);
      }

    });

    /*
    ** Fun????o de Mudan??a do Status e inser????o de Novo Apontamento
    */
    $(document).on('click', '#btn-save-time', function(e){
      $('#btn-save-time').attr('disabled',false);

      var taskid = $('#taskid').val();
      var projectid = $('#projectid').val();
      var statusid = $('#statusid').val();
      var status = $('#status').val();
      var notes = time_notes_mark.value();
      notes = encodeURIComponent( notes.replace(/(\r\n|\n|\r)/gm, "") );
      var spent_on = $('#spent_on').val();
      var hours = $('#horas').val();
      var atividades = $('#atividades').val();
      atividades = encodeURIComponent(atividades.replace(/(\r\n|\n|\r)/gm, "") );
      var atividade = $('#atividade').val();
      var hora_entrada_trabalho = $('#hora_entrada_trabalho').val();
      var hora_saida_almoco = $('#hora_saida_almoco').val();
      var hora_retorno_almoco = $('#hora_retorno_almoco').val();
      var hora_saida_trabalho = $('#hora_saida_trabalho').val();

      //valida????o
      if(taskid && projectid && hours && atividades)
      {

        var data = 'taskid='+taskid+
        '&projectid='+projectid+
        '&statusid='+statusid+
        '&status='+status+
        '&spent_on='+spent_on+
        '&hours='+hours+
        '&notes='+notes+
        '&atividades='+atividades+
        '&activity='+atividade+
        '&hora_entrada_trabalho='+hora_entrada_trabalho+
        '&hora_saida_almoco='+hora_saida_almoco+
        '&hora_retorno_almoco='+hora_retorno_almoco+
        '&hora_saida_trabalho='+hora_saida_trabalho;

        $.ajax({
          url : '{{ URL::to('/changetask')}}',
          data: data,
          type: 'POST',
          success: function(data){
            // $('#message-modal').show().html('<div class="callout callout-success"><h4>Dados atualizados corretamente!</h4></div>').delay(1500).hide(6000);
            Swal.fire({
                            title: 'Success!',
                            html: 'Dados Atualizados Corretamente!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                            });     

            //limpa o formul??rio de Novo Apontamento
            notes = time_notes_mark.value('');
            $('#horas').val('');
            $('#atividades').val('');
            $('#hora_entrada_trabalho').val('');
            $('#hora_saida_almoco').val('');
            $('#hora_retorno_almoco').val('');
            $('#hora_saida_trabalho').val('');

            //carregarAtividades(taskid, projectid);
            carregarMyTasks();
          },
          error: function(XMLHttpRequest, textStatus, errorThrown){
            Swal.fire({
                            title: 'Error!',
                            html: errorThrown,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });     
            // $('#message-modal').show().html('<div class="callout callout-danger"><h4>Status '+textStatus+'!</h4><p>'+errorThrown+'</p></div>').delay(1500).hide(6000);
          }
        });
      }else{
        var campos = '';
        if(!notes) campos += '  '
        Swal.fire({
                            title: 'Error!',
                            html: 'Campos obrigat??rios!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });     
        // $('#message-modal').show().html('<div class="callout callout-danger"><h4>Campos obrigat??rios!</h4></div>').delay(1500).hide(6000);
      }

    });

    $(document).on('click', '#btn-deletar-arquivo', function (e) {
        // var confirmar = confirm('Realmente deseja excluir o arquivo?');
        Swal.fire({
        title: 'Realmente deseja excluir o arquivo?',
        text: "Voc?? n??o ser?? capaz de reverter isso!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim'
      }).then((result) => {
        if (result.isConfirmed) {
         
       
        // if (confirmar == true) {
         
            var attachmentId = $(this).data('timeid');
            var taskid = $('#taskid').val();
            $.ajax({
                url: '{{ URL::to('/delete')}}',
                data: 'attachmentId=' + attachmentId + '&taskid=' + taskid +'&form='+form,
                type: 'POST',
                success: function (data) {
                  Swal.fire({
                            title: 'Success!',
                            html: 'Dados excluidos corretamente!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                            });     
                    // $('#message').show().html('<div class="callout callout-success"><h4>Dados excluidos corretamente!</h4></div>').delay(400).hide(1000);
                    $('#aba-historico').click();
                },
                error: function (xhr, textStatus, errorThrown) {
                  Swal.fire({
                            title: 'Error!',
                            html: xhr.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });     
                    // $('#message').show().html('<div class="callout callout-danger"><h4>Status ' + textStatus + '!</h4><p>' + xhr.responseJSON.message + '</p></div>').delay(1500).hide(6000);
                }
            });
          }
      })});
    /*
    ** Fun????o de Atualizar Apontamento existente
    */
    $(document).on('click', '.btn-delete-time', function(e){
        // var confirmar = confirm('Realmente deseja excluir o apontamento?')
        Swal.fire({
        title: 'Realmente deseja excluir o apontamento?',
        text: "Voc?? n??o ser?? capaz de reverter isso!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim'
      }).then((result) => {
        if (result.isConfirmed) {
          var timeid = $(this).data('timeid');
            var taskid = $('#taskid').val();

            $.ajax({
                url: '{{ URL::to('/deletetime')}}',
                data: 'timeid=' + timeid + '&taskid='+ taskid,
                type: 'POST',
                success: function (data) {
                  Swal.fire({
                            title: 'Success!',
                            html: 'Apontamento Excluido Corretamente!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                            });     
                    // alert('Apontamento exclu??do corretamente!');
                    $('#aba-apontamentos').click();
                    //carregarAtividades(taskid, projectid);
                    //carregarMyTasks();
                },
                error: function (xhr, textStatus, errorThrown) {
                  Swal.fire({
                            title: 'Error!',
                            html: xhr.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });     
                    // $('#message-modal').show().html('<div class="callout callout-danger"><h4>Status ' + textStatus + '!</h4><p>' + errorThrown + '</p></div>').delay(1500).hide(6000);
                }
            });
          }
        });
      })
          


    /*
    ** Fun????o de Atualizar Apontamento existente
    */
    $(document).on('click', '.btn-edit-time', function(e){
      var timeid = $(this).data('timeid');
      var taskid = $('#taskid').val();
      var spent_on = $('#spent_on'+timeid).val();
      var hours = $('#horas'+timeid).val();
      var atividades = $('#atividades'+timeid).val();
      var atividade = $('#activities'+timeid).val();
      var hora_entrada_trabalho = $('#hora_entrada_trabalho'+timeid).val();
      var hora_saida_almoco = $('#hora_saida_almoco'+timeid).val();
      var hora_retorno_almoco = $('#hora_retorno_almoco'+timeid).val();
      var hora_saida_trabalho = $('#hora_saida_trabalho'+timeid).val();
      var tipo_hora = $('#tipo_hora'+timeid).val();

      //valida????o
      if(timeid && hours && atividades)
      {

        var data = 'timeid='+timeid+
        '&taskid='+taskid+
        '&spent_on='+spent_on+
        '&hours='+hours+
        '&atividades='+atividades+
        '&activity='+atividade+
        '&hora_entrada_trabalho='+hora_entrada_trabalho+
        '&hora_saida_almoco='+hora_saida_almoco+
        '&hora_retorno_almoco='+hora_retorno_almoco+
        '&hora_saida_trabalho='+hora_saida_trabalho+
        '&tipo_hora='+tipo_hora;

        $.ajax({
          url : '{{ URL::to('/savetime')}}',
          data: data,
          type: 'POST',
          success: function(data){
            Swal.fire({
                            title: 'Success!',
                            html: 'Dados Atualizados Corretamente',
                            icon: 'success',
                            confirmButtonText: 'OK'
                            });    
              $('#aba-apontamentos').click();
            //carregarAtividades(taskid, projectid);
            //carregarMyTasks();
          },
          error: function(xhr, textStatus, errorThrown){
            Swal.fire({
                            title: 'Error!',
                            html: xhr.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });    
            // $('#message-modal').show().html('<div class="callout callout-danger"><h4>Status '+textStatus+'!</h4><p>'+errorThrown+'</p></div>').delay(1500).hide(6000);
          }
        });
      }else{
        var campos = '';
        if(!notes) campos += '  '
        Swal.fire({
                            title: 'Error!',
                            html: 'Campos obrigat??rios!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });    
        // $('#message-modal').show().html('<div class="callout callout-danger"><h4>Campos obrigat??rios!</h4></div>').delay(1500).hide(6000);
      }

    });

    var form;
    var custom;
    $(document).on('change','#fileUpload', function (event) {
        form = new FormData();
        var files = event.target.files;
        console.log(files);
        for (var i = 0; i < files.length; i++) {
          form.append('fileUpload[]', files[i]);
        }
        var taskid = $('#taskid').val();
        form.append('taskid',taskid);
        var projectid = $('#projectid').val();
        form.append('projectid',projectid);
    });

    
    $(document).on('change','#fileUploadChamado', function (event) {
        form = new FormData();
        var files = event.target.files;
        console.log(files);
        for (var i = 0; i < files.length; i++) {
          form.append('fileUpload[]', files[i]);
        }
        var taskid = $('#taskid').val();
        form.append('taskid',taskid);
        var projectid = $('#projectid').val();
        form.append('projectid',projectid);
    });
    $(document).on('change','#fileUploadNew', function (event) {
        form = new FormData();
        var files = event.target.files;
        console.log(files);
        for (var i = 0; i < files.length; i++) {
          form.append('fileUpload[]', files[i]);
          
        }
    });
    $(document).on('change','#customUpload', function (event) {
        custom = new FormData();
        var files = event.target.files;
        console.log(files);
        for (var i = 0; i < files.length; i++) {
          custom.append('customUpload[]', files[i]);
          
        }
    });

    $(document).on('click','#btnEnviarChamado', function () {
        $.ajax({
            url : '{{ URL::to('/anexar')}}',
            data: form,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){
              Swal.fire({
                            title: 'Success!',
                            html: 'Anexado com Sucesso!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                            }).then((result) => {
                            if (result.isConfirmed) {
                            location.reload(true);
                            }
                           })  
            },
            error: function(xhr, textStatus, errorThrown){
              Swal.fire({
                            title: 'Error ao Anexar!',
                            html: xhr.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            }).then((result) => {
                            if (result.isConfirmed) {
                            location.reload(true);
                            }
                           })     
            }
        });
    });

    $(document).on('click', '#capturar-nochamado', function(e){
          var taskid = $(this).data('taskid');
          var rowid = $(this).data('rowid');
          var cap_chamado = 1;
          var fila = $(this).data('fila');
          var t = $("#total_inprogress").text();
          var total = parseInt(t);
          var statusid = 2;
          if(total >= 3) {
            Swal.fire({
                            title: 'Error!',
                            html: 'Voc?? j?? possui 3 chamados!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                });
          }else {
            var contador = 0;
            var cont_ativo = localStorage.getItem('contador');
            
            var text = prompt("Justifique ?? Captura!");
            if(!text){
              Swal.fire({
                            title: 'Error!',
                            html: '?? Necess??rio justificar capturas de chamados fora da fila!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                });
              return false;
            }
            if (cont_ativo == 1) {
              Swal.fire({
                            title: 'Success!',
                            html: 'Chamado capturado com sucesso!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                });
                            
            } else {
              // if (confirm('Capturado com sucesso! Iniciar o Contador no chamado ' + taskid + '?')) {
              //   contador = 1;
              // }
              Swal.fire({
              title: 'Capturado com sucesso! Iniciar o Contador no chamado ' + taskid + '?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Sim'
            }).then((result) => {
              if (result.isConfirmed) {
                contador = 1;
              }
              $.ajax({
              url: '{{ URL::to('/capturetask')}}',
              data: 'taskid=' + taskid + '&rowid=' + rowid + '&contador=' + contador + '&confirm=' +cap_chamado +'&fila=' +fila +'&text=' +text +'&statusid=' +statusid,
              type: 'POST',
              success: function (data) {
                var sla = 2;
                localStorage.setItem('sla', 2);
                location.reload(true);

              },
              error: function(xhr, textStatus, errorThrown){
                Swal.fire({
                            title: 'Error!',
                            html: xhr.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });    
              // $('#message').show().html('<div class="callout callout-danger"><h4>Status '+textStatus+'!</h4><p>'+xhr.responseJSON.message+'</p></div>').delay(1500).hide(6000);
            }
            });
            })

            }
          }
        });

    //criar um novo chamado
   $(document).on('click','#btn_new_task',function(e){
      if($("#new_private").is(":checked") == true){
        $("#new_private").val('true');
      }
      else{
        $("#new_private").val('');
      }
      var validar_fixo = false;
      

      var tracker_id = $('#new_tracker').val();
      var status_id = $('#new_status').val();
      //valida????o de campos obrigat??rios padr??o
      // // $('#chamado').find('[required=required]').each(function(){
      //     if(!$(this).val()){
      //         validar_fixo = true;
      //       }
      //     else{
      //       validar_fixo = false;  
      //     }
      // });   
    var message_fixo = '';
    if(!tracker_id && !status_id){
        validar_fixo = true;
         message_fixo = 'Campo "Tipo" e "Situa????o" N??o Preenchidos!';
         
    }
    else if(!tracker_id){
       validar_fixo = true;  
       message_fixo = 'Campo "Tipo" N??o Preenchido!'; 
    }
    else if(!status_id){
      message_fixo = 'Campo "Situa????o" N??o Preenchido!'; 

    }
    else{
      validar_fixo = false;  
    }

    if(validar_fixo) {
      Swal.fire({
                            title: 'Error!',
                            html: message_fixo,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });    
      //  alert(message_fixo);
        return false;
      }

      var project_id = $('#project_id').val();
      var subject = $('#new_title').val();
      var priority = $('#new_priority').val();
      var description = new_description_mark.value();
      var category_id = $('#new_category').val();
      var assigned_to_id = $('#new_transferir').val();
      var parent_issue = $('#new_tarefa_pai').val();
      var is_private = $('#new_private').val();
      var version = $('#new_version').val();
      var watchers = $('#new_watcher').val();
      var start_date = $('#new_created_on').val();
      var due_date = $('#new_due_date').val();
      var estimated_hours =  $('#new_spent_hours').val();
      
      //valida????o tipo e status
      
      var data = '&project_id='+project_id+
      '&tracker_id='+tracker_id+
      '&status_id='+status_id+
      '&subject='+subject+
      '&priority='+priority+
      '&description='+description+
      '&category_id='+category_id+
      '&assigned_to_id='+assigned_to_id+
      '&parent_issue='+parent_issue+
      '&is_private='+is_private+
      '&version='+version+
      '&watchers='+watchers+
      '&start_date='+start_date+
      '&due_date='+due_date+
      '&estimated_hours='+estimated_hours;
      
    var validar = false;
    var message = 'Favor preencher os campos obrigat??rios!';
      $('#chamado').find('.issue_required').each(function(el, value){
            var obj = $(this).attr('id');
            var valor = $(this).val();
            var help = $('#help_'+obj);
            if(valor){
                help.removeClass('has-error');
                validar = false;
            }else{
                help.addClass('has-error');
                validar = true;
            }
        });
    if(validar) {
      Swal.fire({
                            title: 'Error!',
                            html: message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });            return false;
      }

     //campos customizados
     for (var i = 1; i < 55; i++) {
                    var el = $('#cf_'+i);

                    if(typeof el !== 'undefined')
                        data += '&cf_' + i +'=' + el.val();
                }
    var html = '';
    var taskid = '';

    if(form){
      $.ajax({
            url : '{{ URL::to('/anexarnew')}}',
            data: form,
            processData: false,
            contentType: false,
            async: false,
            type: 'POST',
            success: function(data){
              html = data;
            },
            error: function(xhr, textStatus, errorThrown){
              Swal.fire({
                            title: 'Error!',
                            html: xhr.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });    
              // $('#message').show().html('<div class="callout callout-danger"><h4>Status '+textStatus+'!</h4><p>'+xhr.responseJSON.message+'</p></div>').delay(1500).hide(6000);
            }
        });
      }
    $.ajax({
                    url : "{{URL::to('/savenewtask')}}",
                    data: data+'&upload='+html,
                    type: 'POST',
                    dataType: 'json',
                    success: function(data){
                      taskid = data['id'];
                      if(custom){
                        custom.append('taskid',taskid);
                            $.ajax({
                                  url : '{{ URL::to('/anexarcustom')}}',
                                  data: custom,
                                  processData: false,
                                  contentType: false,
                                  type: 'POST',
                                  success: function(data){
                                  },
                                  error: function(xhr, textStatus, errorThrown){
                                    Swal.fire({
                                    title: 'Error!',
                                    html: xhr.responseJSON.message,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                    });    
                                    // $('#message').show().html('<div class="callout callout-danger"><h4>Status '+textStatus+'!</h4><p>'+xhr.responseJSON.message+'</p></div>').delay(1500).hide(6000);
                                  }
                           });
                      }
                      // var c = confirm('Tarefa ' + '#' + taskid + ' Criada Com Sucesso!' +
                      //  ' Deseja ser redirecionado(a) para a p??gina?');
                      //  if(c == true){
                      //   location.assign("{{ URL::to('/taskreport')}}/" + taskid);
                      //  }
                      Swal.fire({
                        title: 'Tarefa ' + '#' + taskid + ' Criada Com Sucesso!' + ' Deseja ser redirecionado(a) para a p??gina?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sim'
                      }).then((result) => {
                        if (result.isConfirmed) {
                            location.assign("{{ URL::to('/taskreport')}}/" + taskid);
                        }
                      })
                    },
                    error: function(xhr, textStatus, errorThrown){
                      Swal.fire({
                            title: 'Error!',
                            html: xhr.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });    
                        // $('#message').show().html('<div class="callout callout-danger"><h4>Status '+textStatus+'!</h4><p>'+xhr.responseJSON.message+'</p></div>').delay(1500).hide(6000);
                    },
         });
                                                      

  });

  
    function calcularHoraTrabalho(taskid) {
        var v_entrada = $('#hora_entrada_trabalho' + taskid).val();
        entrada = v_entrada.split(':');
        var minutos_entrada = parseInt(entrada[0]) * 60 + parseInt(entrada[1]);

        var v_almoco = $('#hora_saida_almoco' + taskid).val();
        var minutos_almoco = 0;
        if (v_almoco) {
            almoco = v_almoco.split(':');
            minutos_almoco = parseInt(almoco[0]) * 60 + parseInt(almoco[1]);
        }

        var v_retorno = $('#hora_retorno_almoco' + taskid).val();
        var minutos_retorno = 0;
        if (v_retorno) {
            retorno = v_retorno.split(':');
            minutos_retorno = parseInt(retorno[0]) * 60 + parseInt(retorno[1]);
        }

        var v_saida = $('#hora_saida_trabalho' + taskid).val();
        saida = v_saida.split(':');
        var minutos_saida = parseInt(saida[0]) * 60 + parseInt(saida[1]);

        if (minutos_entrada > 0 && minutos_saida > 0) {

            if (minutos_almoco != 0 && minutos_retorno != 0) {
                var horas = ((minutos_saida - minutos_retorno) + (minutos_almoco - minutos_entrada)) / 60;

            } else {
                var horas = (minutos_saida - minutos_entrada) / 60;

            }

            $('#horas' + taskid).val(horas);

            var data = $('#spent_on' + taskid).val();
            if (data) {
                var dados = 'data=' + data + '&hora_entrada=' + v_entrada + '&hora_saida=' + v_saida;
                $.ajax({
                    url: '{{ URL::to('/checarhorario')}}',
                    data: dados,
                    type: 'POST',
                    success: function (data) {
                        // console.log(data);
                        $('#alerta_horario').empty();
                        if (Object.keys(data).length) {
                            $('#alerta_horario' + taskid).html('<span class="text-red">Hor??rio confitante com chamado <b>' + data[0].issue_id + '</b> do dia <b>' + data[0].spent_on + '</b> - Entrada: <b>' + data[0].hora_entrada + '</b> e Sa??da: <b>' + data[0].hora_saida + '</b></span>');
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                      Swal.fire({
                            title: 'Error!',
                            html: xhr.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });    
                      // $('#message').show().html('<div class="callout callout-danger"><h4>Status '+textStatus+'!</h4><p>'+xhr.responseJSON.message+'</p></div>').delay(1500).hide(6000);
                    }
                });
            }
        }
    }



    //apontamentos aba "Chamado"
    $(document).on('change','.calcular', function () {
      var taskid = $('#edit_task_id').val();
      calcularHoraTrabalho('_'+taskid);
    });

    //apontamentos aba "Novo Apontamento"
    $(document).on('change','.calcular_novo', function () {

      calcularHoraTrabalho('');
    });

    //apontamentos aba "Apontamentos"
    $(document).on('change','.calcular_edit', function () {
      var time_id = $(this).data('timeid');
      calcularHoraTrabalho(time_id);
    });

    $(document).on('click', '.taskdetail', function(e){
      var taskid = $(this).data('taskid');
      var task = $(this).data('task');
      var projectid = $(this).data('projectid');

      var data = 'taskid='+taskid+
                 '&task='+task+
                 '&projectid='+projectid;

       $('#title-detail').html('#'+taskid+' - '+task);
       $('#content-detail').html('Carregando dados...');

      $.ajax({
        url : '{{ URL::to('/taskdetail')}}',
        data: data,
        type: 'POST',
        success: function(data){
          $('#content-detail').html(data);
          $('#taskid').val();
          $('#projectid').val(projectid);
          $('#taskid').val(taskid);
          $('#btn-save-task').show();
          $('#btn-save-notes').show();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
          $('#content-detail').html('<div class="callout callout-danger"><h4>Status '+textStatus+'!</h4><p>'+errorThrown+'</p></div>').delay(1500).hide(6000);
        }
      });
    });

    $(document).on('click', '#btn-save-notes', function(e){
      var taskid = $('#taskid').val();

      var notes = notes_task_mark.value();
      // notes = encodeURIComponent( notes.replace(/(\r\n|\n|\r)/gm, "") );

      if(notes) {
          var data = 'taskid=' + taskid +
              '&notes=' + notes;
          $.ajax({
              url: '{{ URL::to('/savenotes')}}',
              data: data,
              type: 'POST',
              dataType: 'json',
              success: function (data) {
                    Swal.fire({
                            title: 'Success!',
                            html: 'Notas atualizadas com sucesso!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                            }).then((result) => {
                            if (result.isConfirmed) {
                            location.reload(true);
                            }
                           })    
                      // $('#message').show().html('<div class="callout callout-success"><h4> Notas atualizadas com sucesso!</h4></div>').delay(400).hide(1000);
              },
              error: function (XMLHttpRequest, textStatus, errorThrown) {
                Swal.fire({
                            title: 'Error!',
                            html: errorThrown,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });                 
                 }
              });
            }    
         });

    
        $(document).on('click', '#btn-save-task', function(e){
            var validar = false;
            var taskid = $('#edit_task_id').val();
            var taskparar = $('#taskid_contador').val();
            var message = 'Favor preencher os campos obrigat??rios!';
            var novasituacao = $('#novasituacao').val();
            var descricao_html = $('#html-descricao').html();
            /*
            ** iniciar o cronometro quando iniciar o atendimento => In Progress
            */
            // if(taskid==taskparar){
            //     $('#btn-save-task').attr('disabled',true);
            //     alert('Voc?? n??o pode alterar o status desse chamado com o contador ativo!');

            // }
            // else{
                var contador = 0;
                cont = localStorage.getItem('contador');
                if( cont == 0 && novasituacao==2 || novasituacao==14 || novasituacao==16 || novasituacao==11  ){
                    // if(confirm('Iniciar o Contador no chamado ' + $('#edit_task_id').val() + '?')){
                    //     contador=1;
                    // }
                    Swal.fire({
                      title: 'Iniciar o Contador no chamado ' + $('#edit_task_id').val() + '?',
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Sim'
                    }).then((result) => {
                      if (result.isConfirmed) {
                        contador=1;
                      }
                    })
                }

                // if(novasituacao==0){
                //   message = 'Informe a Nova Situa????o!';
                //   validar=true;
                // }

                //valida????o dos customFields caso obrigat??rio
                $('#chamado').find('.issue_required').each(function(el, value){
                    var obj = $(this).attr('id');
                    var valor = $(this).val();
                    var help = $('#help_'+obj);
                    if(valor){
                        help.removeClass('has-error');
                        validar = false;
                    }else{
                        help.addClass('has-error');
                        validar = true;
                    }
                });

                if(novasituacao!=0){
                    //valida????o dos apontamentos caso obrigat??rios
                    var apont = $('#cf_26_'+taskid).val();
                    if(apont==1){
                        $('#novoapontamento').find('.required').each(function(el, value){
                            var obj = $(this).attr('id');
                            var valor = $(this).val();
                            var help = $('#help_'+obj);
                            if(valor){
                                help.removeClass('has-error');
                                validar = false;
                            }else{
                                help.addClass('has-error');
                                validar = true;
                            }
                        });
                    }
                    //se os apontamentos forem obrigat??rios
                    var data_apont = '';
                    var apont = $('#cf_26_'+taskid).val();
                    if(apont==1){
                        var spent_on = $('#spent_on_'+taskid).val();
                        var hours = $('#horas_'+taskid).val();
                        var atividades = $('#atividades_'+taskid).val();
                        atividades = encodeURIComponent( atividades.replace(/(\r\n|\n|\r)/gm, "") );
                        var atividade = $('#atividade_'+taskid).val();
                        var hora_entrada_trabalho = $('#hora_entrada_trabalho_'+taskid).val();
                        var hora_saida_almoco = $('#hora_saida_almoco_'+taskid).val();
                        var hora_retorno_almoco = $('#hora_retorno_almoco_'+taskid).val();
                        var hora_saida_trabalho = $('#hora_saida_trabalho_'+taskid).val();
                        var tipo_hora = $('#tipo_hora_'+taskid).val();

                        var data_apont = '&spent_on='+spent_on+
                            '&hours='+hours+
                            '&atividades='+atividades+
                            '&activity='+atividade+
                            '&hora_entrada_trabalho='+hora_entrada_trabalho+
                            '&hora_saida_almoco='+hora_saida_almoco+
                            '&hora_retorno_almoco='+hora_retorno_almoco+
                            '&hora_saida_trabalho='+hora_saida_trabalho+
                            '&tipo_hora='+tipo_hora;
                    }else{
                        apont='';
                    }
                }

                if(validar) {
                  Swal.fire({
                            title: 'Error!',
                            html: message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });                      
                    return false;
                }
                //return false;

                var projectid = $('#edit_project_id').val();
                var statusid = $('#novasituacao').val();
                var description = description_mark.value();
                // description = description.replace(/([\u0025])/g, "% ");
                // description = encodeURIComponent(description.replace(/(\r\n|\n|\r)/gm, "") );
                
                var title = $('#title').val();
                var assignedid = $('#transferir_para').val();
                var created_on = $('#created_on').val();
                var priority = $('#priority').val();
                var spent_hours = $('#spent_hours').val();
                var due_date = $('#due_date').val();
                var tracker = $('#tracker').val();
                var author = $('#author').val();
                var done_ratio = $('#done_ratio').val();

                var notes = notes_task_mark.value();
                // notes = notes.replace(/<.*?>/g, '');
                // notes = encodeURIComponent( notes.replace(/(\r\n|\n|\r)/gm, "") );

                if($('#input_description').val() == description){
                  description = '';
                }
                if(title == $('#input_title').val()){
                  title = '';
                }
                if(tracker == $('#input_tracker').val()){
                  tracker = '';
                }
                if(priority == $('#input_priority').val()){
                  priority = '';
                }
                var data = 'taskid='+taskid+
                    '&notes='+notes+
                    '&projectid='+projectid+
                    '&title='+title+
                    '&statusid='+statusid+
                    '&created_on='+created_on+
                    '&priority='+priority+
                    '&assignedid='+assignedid+
                    '&spent_hours='+spent_hours+
                    '&tracker='+tracker+
                    '&due_date='+due_date+
                    '&author='+author+
                    '&done_ratio='+done_ratio+
                    '&novasituacao='+novasituacao+
                    '&contador='+contador+
                    '&apont='+apont+data_apont+
                    '&description='+description

                //campos customizados
                for (var i = 1; i < 55; i++) {
                    var el = $('#cf_'+i+'_'+taskid);
                    var alterar = $('#input_cf_'+i+'_'+taskid).val();

                    if(typeof el !== 'undefined'){
                        if(alterar == el.val()){
                            data += '&cf_' + i + '_'+taskid+'=';
                        }
                        else{
                          data += '&cf_' + i + '_'+taskid+'=' + el.val();
                        }
                    }
                }
                //alterar chamado para in_progress
                $.ajax({
                    url : '{{ URL::to('/edittask')}}',
                    data: data,
                    type: 'POST',
                    dataType: 'json',
                    success: function(data){
                      var dados = data;
                        for(var i in dados){
                        var item = dados[i];
                        }
                        if(item.id == 1){
                            Swal.fire({
                            title: 'Error!',
                            text: 'ERRO: N??o foi possivel atualizar os dados na ferramenta do cliente!',
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });
                        }else{
                            Swal.fire({
                            title: 'Sucesso!',
                            text: 'Dados atualizados com sucesso!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                            }).then((result) => {
                            if (result.isConfirmed) {
                            if(form){
                              $('#btnEnviarChamado').trigger('click');
                            }
                            else{
                              location.reload(true);
                            }
                            }
                           })
                        }
                    },
                    error: function(xhr, textStatus, errorThrown){
                      Swal.fire({
                            title: 'Error!',
                            html: xhr.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });
                        // $('#message').show().html('<div class="callout callout-danger"><h4>Status '+textStatus+'!</h4><p>'+xhr.responseJSON.message+'</p></div>').delay(1500).hide(6000);
                    }
                });



            });
     
 

    /*
    ** Fun????o para pesquisar chamado
    */
    function pesquisarChamado(){
      var taskid = $('#numerochamado').val();
      var task = 'Pesquisar Chamado';
      var projectid = '';

      var data = 'taskid='+taskid+
                 '&task='+task+
                 '&projectid='+projectid;

       $('#title-detail').html('#'+taskid+' - '+task);
       $('#content-detail').html('Carregando dados...');

      $.ajax({
        url : '{{ URL::to('/taskdetail')}}',
        data: data,
        type: 'POST',
        success: function(data){
          $('#content-detail').html(data);
          // CKEDITOR.replace( 'description',{entities:false} );
          // CKEDITOR.replace( 'notes',{entities:false} );
          $('#btn-save-task').hide();
          $('#btn-save-notes').hide();
        },
        error: function(xhr, textStatus, errorThrown){
          Swal.fire({
                            title: 'Error!',
                            html: xhr.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });    
          // $('#content-detail').html('<div class="callout callout-danger"><h4>Status '+textStatus+'!</h4><p>'+xhr.responseJSON.message+'</p></div>').delay(1500).hide(6000);
        }
      });
      
    }

    $(document).on('keydown', '#numerochamado', function(e){
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) {
        $("#pesquisarchamado").click();
        return false;
      };
    });

    $(document).on('click', '#pesquisarchamado', function(e){
      var campo = $('#numerochamado').val();
      if(campo==''){
        $('#title-detail').html('Error');
        $('#content-detail').html('Nenhum chamado encontrado...');
        return;
      }
        pesquisarChamado();
    });

    $(document).on('click', '#aba-apontamentos', function(e){
      $('#content-edit-apontamentos').html('Carregando dados...');

      var taskid = $('#edit_task_id').val();
      var projectid = '';

      var data = 'taskid='+taskid+
                 '&projectid='+projectid;
      $.ajax({
        url : '{{ URL::to('/edithours')}}',
        data: data,
        type: 'POST',
        success: function(data){
          $('#content-edit-apontamentos').html(data);

        },
        error: function(xhr, textStatus, errorThrown){
          Swal.fire({
                            title: 'Error!',
                            html: xhr.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });    
          // $('#message').html('<div class="callout callout-danger"><h4>Status '+textStatus+'!</h4><p>'+xhr.responseJSON.message+'</p></div>').delay(1500).hide(6000);
        }
      });
    });

    $(document).on('click', '#aba-change-apontamentos', function(e){
      $('#content-change-apontamentos').html('Carregando dados...');

      var taskid = $('#taskid').val();
      var projectid = '';

      var data = 'taskid='+taskid+
                 '&projectid='+projectid;
      $.ajax({
        url : '{{ URL::to('/edithours')}}',
        data: data,
        type: 'POST',
        success: function(data){
          $('#content-change-apontamentos').html(data);
        },
        error: function(xhr, textStatus, errorThrown){
          Swal.fire({
                            title: 'Error!',
                            html: xhr.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });    
          // $('#content-detail').html('<div class="callout callout-danger"><h4>Status '+textStatus+'!</h4><p>'+xhr.responseJSON.message+'</p></div>').delay(1500).hide(6000);
        }
      });
    });

    $(document).on('click', '#aba-historico', function(e){
      $('#content-historico').html('Carregando dados...');

      var taskid = $('#edit_task_id').val();
      var projectid = '';

      var data = 'taskid='+taskid+
                 '&projectid='+projectid;
      $.ajax({
        url : '{{ URL::to('/historico')}}',
        data: data,
        type: 'POST',
        success: function(data){
          $('#content-historico').html(data);
        },
        error: function(xhr, textStatus, errorThrown){
          Swal.fire({
                            title: 'Error!',
                            html: xhr.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });    
          // $('#content-detail').html('<div class="callout callout-danger"><h4>Status '+textStatus+'!</h4><p>'+xhr.responseJSON.message+'</p></div>').delay(1500).hide(6000);;
        }
      });
    });

    /*
    ** Transfere o Chamado para outro Analista ou Grupo/Fila
    */
    $(document).on('change', '.transferir', function(e){

      var c = confirm("Deseja transferir esse chamado?");
      if(c==true){
        var taskid = $(this).data('taskid');
        var userid = $(this).val();
        $.ajax({
          url : '{{ URL::to('/transfertask')}}',
          data: 'taskid='+taskid+'&userid='+userid,
          type: 'POST',
          success: function(data){
            Swal.fire({
                            title: 'Success!',
                            html: 'Chamado transferido!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                            }).then((result) => {
                            if (result.isConfirmed) {
                            location.reload(true);
                            }
                           });  
          },
          error: function(xhr, textStatus, errorThrown){
            Swal.fire({
                            title: 'Error!',
                            html: xhr.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                            });    
            // $('#content-detail').html('<div class="callout callout-danger"><h4>Status '+textStatus+'!</h4><p>'+xhr.responseJSON.message+'</p></div>').delay(1500).hide(6000);
          }
        });
      }else{
        $(this).val("");
      }

    });

    /*
    ** Bot??o Stop Cron??metro - abre o modal
    */
    $(document).on('click', '#btn-stop-contador', function(e){

      let taskid = $(this).data('taskid');

      $('#taskid_contador').val(taskid);

      $('#modal-cronometro').modal('show');

    });

    </script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop
