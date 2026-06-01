<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuideController extends Controller
{
    public function userGuide()
    {
        $guidePath = base_path('docs/panduan-pengguna.md');
        
        if (!file_exists($guidePath)) {
            return back()->with('error', 'Panduan pengguna tidak ditemukan.');
        }
        
        $content = file_get_contents($guidePath);
        
        // Simple markdown to HTML conversion
        $html = $this->markdownToHtml($content);
        
        return view('guides.user', compact('html'));
    }
    
    public function adminGuide()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke panduan admin.');
        }
        
        $guidePath = base_path('docs/panduan-admin.md');
        
        if (!file_exists($guidePath)) {
            return back()->with('error', 'Panduan admin tidak ditemukan.');
        }
        
        $content = file_get_contents($guidePath);
        
        // Simple markdown to HTML conversion
        $html = $this->markdownToHtml($content);
        
        return view('guides.admin', compact('html'));
    }
    
    private function markdownToHtml($markdown)
    {
        // Simple markdown parser
        $html = $markdown;
        
        // Headers
        $html = preg_replace('/^### (.*?)$/m', '<h3>$1</h3>', $html);
        $html = preg_replace('/^## (.*?)$/m', '<h2>$1</h2>', $html);
        $html = preg_replace('/^# (.*?)$/m', '<h1>$1</h1>', $html);
        
        // Bold
        $html = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $html);
        
        // Italic
        $html = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $html);
        
        // Links
        $html = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2" target="_blank">$1</a>', $html);
        
        // Unordered lists
        $html = preg_replace('/^- (.*?)$/m', '<li>$1</li>', $html);
        $html = preg_replace('/(<li>.*<\/li>\n?)+/s', '<ul>$0</ul>', $html);
        
        // Numbered lists
        $html = preg_replace('/^\d+\. (.*?)$/m', '<li>$1</li>', $html);
        
        // Code blocks
        $html = preg_replace('/```(.*?)```/s', '<pre><code>$1</code></pre>', $html);
        
        // Inline code
        $html = preg_replace('/`(.*?)`/', '<code>$1</code>', $html);
        
        // Horizontal rules
        $html = preg_replace('/^---$/m', '<hr>', $html);
        
        // Line breaks
        $html = nl2br($html);
        
        // Clean up empty lists
        $html = preg_replace('/<ul>\s*<\/ul>/', '', $html);
        
        return $html;
    }
}
