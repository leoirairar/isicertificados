<div class="notifi__title">
        <span id="quantity" style="display:none;">{{$unReadedNotifications->count()}}</span>
    @if ($unReadedNotifications->count() == 1)
    <p id="notifiTitle">{{'Usted tiene '.$unReadedNotifications->count().' notificación'}}</p>
    @else
    <p id="notifiTitle">{{'Usted tiene '.$unReadedNotifications->count().' notificaciones'}}</p>
    @endif  
</div>
@for ($i = 0; $i < 3; $i++)
    @if(isset($unReadedNotifications[$i]))
        <div class="notifi__item">
            <div class="bg-c3 img-cir img-40">
                <i class="zmdi zmdi-file-text"></i>
            </div>
            <div class="content">
                <p>
                    <span>{{$unReadedNotifications[$i]->detail}}
                    @if ($unReadedNotifications[$i]->url != null)
                    
                        <a href="{{ route('notificationRedirect',['param'=>$unReadedNotifications[$i]->url]) }}">ver</a>   
                    @endif
                    </span>
                </p>
                <span style="color: #999;font-size: 12px;">{{\Carbon\Carbon::parse($unReadedNotifications[$i]->created_at)->isoFormat('MMMM DD YYYY, h:mm a')}}</span>
            </div>
        </div>
    @endif
@endfor