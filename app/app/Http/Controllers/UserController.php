<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // プロフィール表示
    public function show()
    {
        $user = Auth::user();
        return view('users.show', compact('user'));
    }

    // プロフィール編集
    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    // 登録編集画面
    public function accountEdit()
    {
        $user = Auth::user();
        return view('users.account_edit', compact('user'));
    }

    public function destroy()
    {
        $user = Auth::user();

        Auth::logout();           // ログアウト
        $user->delete();          // ユーザー削除

        return redirect('/login')->with('success', '退会しました');
    }

    public function accountUpdate(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'メールアドレスを変更しました');
    }

    // 更新処理
    public function update(Request $request)
    {
        $user = Auth::user();

        // バリデーション（アイコンも追加）
        $request->validate([
            'name'  => 'required|string|max:255',
            'icon'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像ファイルのみ許可
        ]);

        $data = [
            'name'  => $request->name,
        ];

        if ($request->hasFile('icon')) {
            // 古いアイコン削除
            if ($user->icon_path) {
                $oldPath = str_replace('storage/', '', $user->icon_path);
                Storage::disk('public')->delete($oldPath);
            }

            // 保存
            $path = $request->file('icon')->store('icons', 'public'); // storage/app/public/icons
            $data['icon_path'] = 'storage/' . $path; // asset() でアクセス可能
        }
        $user->update($data);

        return redirect()->route('users.show')->with('success', 'プロフィールを更新しました');
    }

    /**
     * 利用停止中ユーザー用画面
     */
    public function suspended()
    {
        return view('users.suspended');
    }
}
