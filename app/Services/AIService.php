<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Prism\Prism\Facades\Prism;

class AIService
{
  public function createTicketSummary(array $data)
  {
    $prompt = $this->buildPrompt($data);

    $providers = [
      env('AI_PRIMARY', 'openai'),
      env('AI_FALLBACK_1', 'gemini'),
      env('AI_FALLBACK_2', 'deepseek'),
      env('AI_FALLBACK_3', 'huggingface'),
    ];

    foreach ($providers as $provider) {
      try {
        $result = $this->callProvider($provider, $prompt);

        if ($result) {
          return $result;
        }
      } catch (\Exception $e) {
        Log::warning("AI provider failed: {$provider}", [
          'error' => $e->getMessage()
        ]);
      }
    }

    return $this->fallbackSummary($data);
  }

  private function callProvider($provider, $prompt)
  {
    return match ($provider) {

      'openai' => $this->openai($prompt),

      'gemini' => $this->gemini($prompt),

      'deepseek' => $this->deepseek($prompt),

      'huggingface' => $this->huggingface($prompt),

      'ollama' => $this->ollama($prompt),

      default => null,
    };
  }

  /* ---------------- PROVIDERS ---------------- */

  private function openai($prompt)
  {
    return Prism::text()
      ->using('openai', 'gpt-4o-mini')
      ->withPrompt($prompt)
      ->generate()
      ->text;
  }

  private function gemini($prompt)
  {
    return Prism::text()
      ->using('gemini', 'gemini-1.5-pro')
      ->withPrompt($prompt)
      ->generate()
      ->text;
  }

  private function deepseek($prompt)
  {
    return Prism::text()
      ->using('deepseek', 'deepseek-chat')
      ->withPrompt($prompt)
      ->generate()
      ->text;
  }

  private function huggingface($prompt)
  {
    return Prism::text()
      ->using('huggingface', 'facebook/bart-large-cnn')
      ->withPrompt($prompt)
      ->generate()
      ->text;
  }

  private function ollama($prompt)
  {
    return Prism::text()
      ->using('ollama', 'llama3')
      ->withPrompt($prompt)
      ->generate()
      ->text;
  }

  /* ---------------- PROMPT ---------------- */

  private function buildPrompt(array $data)
  {
    return "Summarize the ticket and suggest next action.

    Title: {$data['title']}
    Description: {$data['description']}
    Category: {$data['category']}
    Status: {$data['status']}
    Priority: {$data['priority']}

    Return format:
    Summary: ...
    Next Action: ...";
  }

  /* ---------------- FINAL FALLBACK ---------------- */

  private function fallbackSummary(array $data)
  {
    return "Ticket [{$data['priority']}] {$data['status']} - {$data['title']} (No AI available)";
  }
}
