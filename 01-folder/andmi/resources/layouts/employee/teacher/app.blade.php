<!DOCTYPE html>
<html lang="uz">

@include('layouts::employee.head')

<body class="hold-transition sidebar-mini layout-fixed">
    @include('sweetalert::alert')
    <div class="wrapper">
        <!-- Loader -->
        <div class="loader-wrapper">
            <div class="loader"></div>
        </div>

        @php
            use App\Models\Chat\Chat;
            use App\Models\Chat\Message;

            $messages = Message::where('seen', 0)
                ->whereIn('chat_id', function ($query) use ($user) {
                    $query->select('id')
                        ->from('chats')
                        ->where(function ($subQuery) use($user) {
                            $subQuery->where('user_one_id', $user->id)
                                    ->orWhere('user_two_id', $user->id);
                        });
                })
                ->where('user_id', '!=', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            $messages = $messages->unique(function ($message) {
                return $message->chat_id;
            });

            $messages_count = count($messages);
            
            $messages = $messages->map(function ($message) use($user) {
                $sender = $message->user->id == $message->chat->first_user->id ? $message->chat->first_user : $message->chat->second_user;

                return [
                    'id' => $message->chat_id,
                    'fio' => $sender->short_fio(),
                    'picture_path' => $sender->picture_path(),
                    'message' => $message->content,
                    'sended_at' => Carbon\Carbon::parse($message->created_at)->diffForHumans(),
                ];
            })->take(3);
        @endphp

        @include('layouts::employee.teacher.navbar')
        @include('layouts::employee.teacher.sidebar')

        @yield('content')

        @include('layouts::employee.footer')

        @include('layouts::employee.scripts')

    </div>

    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel">Bekor Qilish Izohi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" rows="4" placeholder="Bekor qilish sababini kiriting..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Yopish</button>
                    <button type="button" class="btn btn-primary">Saqlash</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Rad etilish sababi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="reject-reason"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-bs-dismiss="modal">Yopish</button>
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
