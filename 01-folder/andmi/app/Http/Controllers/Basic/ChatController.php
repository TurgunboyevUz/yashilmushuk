<?php

namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;
use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getMessages(Request $request, Chat $chat)
    {
        $user = $request->user();

        if ($chat->user_one_id == $user->id or $chat->user_two_id == $user->id) {
            try {
                $chat->messages()->where('user_id', '!=', $user->id)->update(['seen' => true]);
                $messages = $chat->messages()->with('user')->orderBy('created_at', 'asc')->get();

                $html = view('chat.messages', compact('user', 'messages'))->render();

                return response()->json([
                    'success' => true,
                    'messages' => $html,
                ]);
            } catch (\Throwable $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 401);
            }
        } else {
            return response()->json(['success' => false], 401);
        }
    }

    public function sendMessage(Request $request, Chat $chat)
    {
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $user = $request->user();

        $message = new Message();
        $message->chat_id = $chat->id;
        $message->user_id = $user->id;
        $message->content = $request->message;
        $message->save();

        return response()->json(['success' => true]);
    }

    public function deleteMessage(Request $request, Chat $chat)
    {
        $data = $request->validate([
            'message_id' => 'required|exists:messages,id',
        ]);

        $message = Message::find($data['message_id']);

        if ($message->user_id == $request->user()->id) {
            $message->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false], 401);
        }
    }
}
