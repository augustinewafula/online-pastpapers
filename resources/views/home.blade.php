@extends('layouts.app')

@section('title')
    <title>Home - Online Pastpapers</title>
@endsection

@section('styles')
<style>
  .site-header {
    height:450px; /* Remove affer */
    width:800px;/* Remove affer */
    margin: 50px auto;
  }
  #MainMenu {
      padding:0;
  }
  .navbar-brand {
      padding-left:0;
      padding-right:0;
  }

  /*---------- Search ----------*/
  .result-bucket li {
      padding: 4px 10px;
  }
  .instant-results {
      background: #fff;
      width: 100%;
      color: gray;
      position: absolute;
      top: 100%;
      left: 0;
      border: 1px solid rgba(0, 0, 0, .15);
      border-radius: 4px;
      -webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, .175);
      box-shadow: 0 2px 4px rgba(0, 0, 0, .175);
      display: none;
      z-index: 9;
  }
  .form-search {
      transition: all 200ms ease-out;
      -webkit-transition: all 200ms ease-out;
      -ms-transition: all 200ms ease-out;
  }
  .search-form {
      position: relative;
      max-width: 100%;
  }
  .result-link {
      color: #273a49;
  }
  .result-link .media-body {
      font-size: 13px;
      color: gray;
  }
  .result-link .media-heading {
      font-size: 15px;
      font-weight: 400;
      color: #273a49;
  }
  .result-link:hover,
  .result-link:hover .media-heading,
  .result-link:hover .media-body {
      text-decoration: none;
      color: #273a49
  }
  .result-link .media-object {
      width: 50px;
      padding: 3px;
      border: 1px solid #c1c1c1;
      border-radius: 3px;
  }
  .result-entry + .result-entry {
      border-top:1px solid #ddd;
  }
  .top-keyword {
      margin: 4px 0 0;
      font-size: 12px;
      font-family: Arial;
  }
  .top-keyword a {
      font-size: 12px;
      font-family: Arial;
  }
  .top-keyword a:hover {
      color: rgba(0, 0, 0, 0.7);
  }
</style>
@endsection

@section('content')
@include('includes.header')
@include('includes.side_menu')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-home"></i> Home</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 home-widget">
          <a href="{{ route('home') }}" >
            <div class="widget-small danger coloured-icon"><i class="icon fa fa-university fa-3x"></i>
              <div class="info">
                <h4>Total Pastpapers</h4>
                <p><b>4</b></p>
              </div>
            </div>
          </a>
        </div>
    </div>
    <div class="row">
      <div class="col-md-12">
          <div class="tile">  
              <div class="col-md-8">
                  <div class="form-group">
                      <h3 class="tile-title">Search Pastpapers</h3>
                      <label for="unit" class="{{ $errors->has('unit') ? ' text-danger' : '' }}">Search by unit name or unit code</label>
                      <div id="search-form" class="search-form js-search-form">
                        <form class="form-search" role="search" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" v-model="unit" placeholder="unit name or unit code" />
                                <div class="input-group-append">
                                  <button @click="searchPastpapers()" class="btn btn-primary" type="button">
                                    <i class="fa fa-search"></i>
                                  </button>
                                </div>
                            </div>
                        </form>
                        <div class="instant-results">
                            <ul class="list-unstyled result-bucket">
                                <li v-for="unit in units" :key="unit.id" class="result-entry" data-suggestion="Target 1" :data-position="unit.id" data-type="type" data-analytics-type="merchant">
                                    <a @click.prevent="setText(unit.code,unit.name)" href="#" class="result-link">
                                        <div class="media">
                                            <div class="media-body">
                                                <h4 class="media-heading">@{{unit.code}} - @{{unit.name}}</h4>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>     
                  </div><br>
                <div v-show="pastpapers" style="display: none" class="search-results">
                <h5>Pastpapers Found </h5>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Unit</th>
                            <th>Period</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="pastpaper in pastpapers" :key="pastpaper.id">
                            <td>@{{pastpaper.code}} - @{{pastpaper.unit_name}}</td>
                            <td>@{{pastpaper.from}} to @{{pastpaper.to}}</td>
                            <td>
                                <a :href="pastpaper.pastpaper_name | addFullPath(pastpaper_location)" target="_blank" data-toggle="tooltip" title="View" class="btn btn-sm btn-outline-primary"><i class="fa fa-eye" style="font-size: 15px;"></i></a>
                                <a :href="pastpaper.pastpaper_name | addFullPath(pastpaper_location)" download data-toggle="tooltip" title="Download" class="btn btn-sm btn-outline-primary"><i class="fa fa-download" style="font-size: 15px;"></i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
              </div>
          </div>
      </div>
    </div>
</main>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
<script>
  $(document).ready(function(){
    //Hover Menu in Header
    $('ul.nav li.dropdown').hover(function () {
        $(this).find('.mega-dropdown-menu').stop(true, true).delay(200).fadeIn(200);
    }, function () {
        $(this).find('.mega-dropdown-menu').stop(true, true).delay(200).fadeOut(200);
    });
    
    //Open Search    
    $('.form-search').click(function (event) {
        $(".instant-results").fadeIn('slow').css('height', 'auto');
        event.stopPropagation();
    });

    $('body').click(function () {
        $(".instant-results").fadeOut('500');
    });

  });
</script>
<script>
    var app = new Vue({ 
        el: '#app',
        data: {
            unit: '',
            units: '',
            pastpapers: '',
            pastpaper_location: 'storage/pastpapers'
        },
        methods: {
            setText(unit_code,unit_name){
                var complete_unit_name = unit_code+" - "+unit_name
                this.unit = complete_unit_name
            },
            searchPastpapers(){
                if (this.unit) {                    
                    axios.get('pastpapers/search/'+this.unit).then(({ data }) => {
                        if (data) {
                            this.pastpapers = data        
                        }
                    })
                }
            }
        },
        filters:{
            addFullPath(name,path){
                var name_only = name.substring(0,name.indexOf("."))
                var extension = name.split('.')[1]

                if (extension=='docx') {
                    return path+'/'+name_only+'.pdf'
                }
                return path+'/'+name
            }
        },
        watch: {
            unit (val) {
                if (!val) {
                    this.units = []
                    return
                }
                axios.get('units/search/'+val).then(({ data }) => {
                    if (data) {
                        this.units = data        
                    }
                })
            }
        },
    });
</script>
@if (session('status'))
    <script type="text/javascript">
      $.notify({
            title: "Success : ",
            message: "{{ session('status') }}",
            icon: 'fa fa-check' 
          },{
            type: "info"
      });
    </script>        
@endif   
@endsection