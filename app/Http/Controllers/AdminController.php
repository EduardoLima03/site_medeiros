<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\PageContent;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::pluck('value', 'key');
        $pages = PageContent::orderBy('page')->get()->groupBy('page');
        return view('dashboard.admin.index', compact('settings', 'pages'));
    }

    public function updateSettings(Request $request)
    {
        $allSettings = [
            'primary_color', 'secondary_color', 'text_color', 'dark_green', 'gold',
            'site_name', 'site_description', 'phone_central', 'whatsapp', 'instagram',
            'facebook', 'app_play_store', 'app_app_store', 'cnpj', 'portfolio_url',
            'cadastro_url', 'curriculo_drive',
        ];
        foreach ($allSettings as $field) {
            if ($request->has($field)) {
                SiteSetting::updateOrCreate(
                    ['key' => $field],
                    ['value' => $request->$field]
                );
            }
        }
        return redirect()->route('admin.index')->with('success', 'Configurações salvas!');
    }

    public function updateContent(Request $request)
    {
        $data = $request->validate([
            'page' => 'required|string',
            'section' => 'required|string',
            'content' => 'required|string',
        ]);

        PageContent::updateOrCreate(
            ['page' => $data['page'], 'section' => $data['section']],
            ['content' => $data['content']]
        );

        return redirect()->route('admin.index')->with('success', 'Conteúdo atualizado!');
    }

    public function users()
    {
        $users = \App\Models\User::where('role', '!=', 'admin')->latest()->get();
        return view('dashboard.admin.users', compact('users'));
    }

    public function updateUserRole(Request $request, \App\Models\User $user)
    {
        $data = $request->validate(['role' => 'required|in:rh,marketing,client']);
        $user->update($data);
        return redirect()->route('admin.users')->with('success', 'Permissão atualizada!');
    }

    public function getContentJson(Request $request)
    {
        $page = $request->query('page', 'home');
        $section = $request->query('section', '');
        $content = PageContent::where('page', $page)->where('section', $section)->first();
        return response()->json(['content' => $content ? $content->content : '']);
    }
}
