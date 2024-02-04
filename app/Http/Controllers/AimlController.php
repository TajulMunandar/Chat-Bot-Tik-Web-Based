<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

use SimpleXMLElement;

class AimlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = "Aiml";
        $aimls = $this->getAimlData(); // Mendapatkan data dari XML
        return view('dashboardPage.aiml', ['aimls' => $aimls])->with(compact('page'));
    }

    // Metode untuk mendapatkan data dari file XML
    private function getAimlData()
    {
        $aimlFilePath = storage_path('app/public/chatbot.xml');
        $aimlData = [];

        if (file_exists($aimlFilePath)) {
            $xml = simplexml_load_file($aimlFilePath);
            foreach ($xml->category as $category) {
                $randomElement = $category->template->random ?? null;
                $template = [
                    'pattern' => (string)$category->pattern,
                    'template' => ($randomElement) ? ['randomOptions' => $this->getRandomOptions($randomElement)] : (string)$category->template,
                ];

                $aimlData[] = $template;
            }
        }

        return $aimlData;
    }

    private function getRandomOptions($randomElement)
    {
        $randomOptions = [];
        foreach ($randomElement->li as $li) {
            $randomOptions[] = (string)$li;
        }
        return $randomOptions;
    }

    // Metode untuk menyimpan data ke file XML
    private function saveAimlData($aimlData)
    {
        $aimlFilePath = storage_path('app/public/chatbot.xml'); // Sesuaikan path sesuai kebutuhan

        $xml = new SimpleXMLElement('<aiml></aiml>');
        foreach ($aimlData as $aimlItem) {
            $category = $xml->addChild('category');
            $category->addChild('pattern', $aimlItem['pattern']);

            // Check if the template contains randomOptions
            if (isset($aimlItem['template']['randomOptions'])) {
                $template = $category->addChild('template');
                $random = $template->addChild('random');
                foreach ($aimlItem['template']['randomOptions'] as $option) {
                    $random->addChild('li', $option);
                }
            } else {
                // If no randomOptions, add the template directly
                $category->addChild('template', $aimlItem['template']);
            }
        }

        $xml->asXML($aimlFilePath);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patern' => 'required',
            'template' => 'required',
        ]);

        $aimlData = $this->getAimlData();
        $template = $this->parseTemplate($validated['template']);

        $aimlData[] = [
            'pattern' => $validated['patern'],
            'template' => $template,
        ];

        $this->saveAimlData($aimlData);

        return redirect('/dashboard/aiml')->with('success', 'AIML baru berhasil ditambahkan!');
    }

    public function update(Request $request, $key)
    {
        $validated = $request->validate([
            'patern' => 'required',
            'template' => 'required',
        ]);

        $aimlData = $this->getAimlData();
        $template = $this->parseTemplate($validated['template']);

        $aimlData[$key] = [
            'pattern' => $validated['patern'],
            'template' => $template,
        ];

        $this->saveAimlData($aimlData);

        return redirect('/dashboard/aiml')->with('success', 'Data AIML berhasil diperbarui!');
    }

    private function parseTemplate($template)
    {
        if (strpos($template, ',') !== false) {
            // Jika template mengandung koma, pecah template menjadi array
            $options = array_map('trim', explode(',', $template));
            return ['randomOptions' => $options];
        } else {
            // Jika tidak mengandung koma, kembalikan template langsung
            return $template;
        }
    }

    public function destroy($key)
    {
        $aimlData = $this->getAimlData();

        if (array_key_exists($key, $aimlData)) {
            unset($aimlData[$key]);
            $this->saveAimlData($aimlData);
            return redirect('/dashboard/aiml')->with('success', 'AIML data has been deleted!');
        }

        return redirect('/dashboard/aiml')->with('failed', 'Failed to delete AIML data!');
    }
}
