@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="font-weight: bold">Notificaciones</div>
                    <div class="card-body">

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Nuevas notificaciones</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Notificaciones leidas</a>
                              </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                  <table class="table">
                                    <thead>
                                        <th>Notificaciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($unReadedNotifications as $unReadedNotification)
                                        <tr>
                                            <td>
                                                <p>
                                                    <span>{{$unReadedNotification->detail}}
                                                    @if ($unReadedNotification->url != null)
                                                        @if (strpos($unReadedNotification->url, "attendanceModal") !== false )
                                                            @php
                                                                $modalInfo = explode("/",$unReadedNotification->url); 
                                                            @endphp
                                                            <i class="btn" id="modalUser" data-course="{{$modalInfo[1]}}" data-toggle="modal" data-target="{{'#'.$modalInfo[0]}}" style="color: #3490dc;text-decoration: none;background-color: transparent;font-size: 16px;padding-left: 1px;">Ver Lista</i>
                                                        @else
                                                            <a href="{{url($unReadedNotification->url)}}">ver</a>
                                                        @endif 
                                                    @endif
                                                    </span>
                                                </p>
                                                <span style="color: #999;font-size: 12px;">{{\Carbon\Carbon::parse($unReadedNotification->created_at)->isoFormat('MMMM DD YYYY, h:mm a')}}</span>
                                            </td>
                                        </tr>      
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <table class="table">
                                        <thead>
                                            <th>Notificaciones</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($readedNotifications as $readedNotification)
                                            <tr>
                                                <td>
                                                    <p>
                                                        <span>{{$readedNotification->detail}}
                                                        @if ($readedNotification->url != null)
                                                            @if (strpos($readedNotification->url, "attendanceModal") !== false )
                                                                @php
                                                                    $modalInfo = explode("/",$readedNotification->url); 
                                                                @endphp
                                                                <i class="btn" id="modalUser" data-course="{{$modalInfo[1]}}" data-toggle="modal" data-target="{{'#'.$modalInfo[0]}}" style="color: #3490dc;text-decoration: none;background-color: transparent;font-size: 16px;padding-left: 1px;">Ver Lista</i>
                                                            @else
                                                                <a href="{{url($readedNotification->url)}}">ver</a>
                                                            @endif 
                                                        @endif
                                                        </span>
                                                    </p>
                                                    <span style="color: #999;font-size: 12px;">{{\Carbon\Carbon::parse($readedNotification->created_at)->isoFormat('MMMM DD YYYY, h:mm a')}}</span>
                                                </td>
                                            </tr>      
                                            @endforeach
                                        </tbody>
                                    </table> 
                              </div>      
                        </div>                        
                    </div>
                </div>
                {{-- modal --}}
                <div class="modal fade" id="attendanceModal" tabindex="-1" role="dialog" aria-labelledby="lableModal" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered attendanceModal-modal-sm" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="lableModal"></h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                             <div class="modal-body">
                               <div id="modalContent" style="text-align: center;"></div>    
                            </div>
                          </div>
                        </div>
                      </div>
                {{-- end modal --}}
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('js/app/notifications.js') }}"></script>
@endsection