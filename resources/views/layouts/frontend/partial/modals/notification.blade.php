<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="padding: 25px;text-align: left;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
            <div>
                <div>
                @auth
                    <ul>
                    @foreach (auth()->user()->unreadNotifications as $index => $notification)
                        <li>
                            <a class="desc" href="{{ route('notification.destroy', [auth()->user()->username, $notification->id]) }}">
                                <span class="">{{ $notification->data['message'] }}</span>
                            </a>
                        </li>
                    @endforeach
                    </ul>
                @endauth
                </div>
            </div>
        </div>
    </div>
  </div>
</div>