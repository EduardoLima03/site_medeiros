<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\PageContent;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalPaginas = PageContent::distinct()->count('page');
        $totalSecoes = PageContent::count();
        $totalSettings = SiteSetting::count();
        $totalUsers = \App\Models\User::where('role', '!=', 'admin')->count();
        return view('dashboard.admin.index', compact('totalPaginas', 'totalSecoes', 'totalSettings', 'totalUsers'));
    }

    public function pages()
    {
        $pages = PageContent::orderBy('page')->get()->groupBy('page');
        $allPages = PageContent::distinct()->orderBy('page')->pluck('page');
        return view('dashboard.admin.pages', compact('pages', 'allPages'));
    }

    public function appearance()
    {
        $settings = SiteSetting::pluck('value', 'key');
        return view('dashboard.admin.appearance', compact('settings'));
    }

    public function settings()
    {
        $settings = SiteSetting::pluck('value', 'key');
        return view('dashboard.admin.settings', compact('settings'));
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
        return redirect()->back()->with('success', 'Configurações salvas!');
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

        return redirect()->route('admin.pages')->with('success', 'Conteúdo atualizado!');
    }

    public function createPage(Request $request)
    {
        $data = $request->validate([
            'page' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
        ]);

        PageContent::firstOrCreate(
            ['page' => $data['page'], 'section' => 'titulo'],
            ['content' => $data['titulo']]
        );

        return redirect()->route('admin.pages')->with('success', "Página '{$data['page']}' criada!");
    }

    public function createSection(Request $request)
    {
        $data = $request->validate([
            'page' => 'required|string|max:255',
            'section' => 'required|string|max:255',
        ]);

        PageContent::firstOrCreate(
            ['page' => $data['page'], 'section' => $data['section']],
            ['content' => '']
        );

        return redirect()->route('admin.pages')->with('success', "Seção '{$data['section']}' adicionada em '{$data['page']}'!");
    }

    public function deleteSection(PageContent $pageContent)
    {
        $pageContent->delete();
        return redirect()->route('admin.pages')->with('success', 'Seção removida!');
    }

    public function menu()
    {
        $settings = SiteSetting::pluck('value', 'key');
        $pages = PageContent::orderBy('page')->get()->groupBy('page');
        $allPages = PageContent::distinct()->orderBy('page')->pluck('page');
        $menuItems = json_decode($settings['nav_menu'] ?? '[]', true);
        return view('dashboard.admin.menu', compact('settings', 'pages', 'allPages', 'menuItems'));
    }

    public function addMenuItem(Request $request)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'required|string|max:255',
        ]);

        $menu = json_decode(SiteSetting::where('key', 'nav_menu')->value('value') ?? '[]', true);
        $menu[] = ['label' => $data['label'], 'url' => $data['url']];
        SiteSetting::updateOrCreate(['key' => 'nav_menu'], ['value' => json_encode($menu)]);

        return redirect()->route('admin.menu')->with('success', 'Item adicionado ao menu!');
    }

    public function removeMenuItem($index)
    {
        $menu = json_decode(SiteSetting::where('key', 'nav_menu')->value('value') ?? '[]', true);
        if (isset($menu[$index])) {
            unset($menu[$index]);
            $menu = array_values($menu);
            SiteSetting::updateOrCreate(['key' => 'nav_menu'], ['value' => json_encode($menu)]);
        }
        return redirect()->route('admin.menu')->with('success', 'Item removido do menu!');
    }

    public function moveMenuItem(Request $request, $index)
    {
        $data = $request->validate(['direcao' => 'required|in:subir,descer']);

        $menu = json_decode(SiteSetting::where('key', 'nav_menu')->value('value') ?? '[]', true);
        if (!isset($menu[$index])) {
            return redirect()->route('admin.menu')->with('error', 'Item não encontrado.');
        }

        $target = $data['direcao'] === 'subir' ? $index - 1 : $index + 1;
        if ($target < 0 || $target >= count($menu)) {
            return redirect()->route('admin.menu');
        }

        $temp = $menu[$index];
        $menu[$index] = $menu[$target];
        $menu[$target] = $temp;

        SiteSetting::updateOrCreate(['key' => 'nav_menu'], ['value' => json_encode(array_values($menu))]);
        return redirect()->route('admin.menu')->with('success', 'Item movido!');
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
