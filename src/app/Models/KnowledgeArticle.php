<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Ai\Embeddings;


class KnowledgeArticle extends Model
{
    protected $fillable = [
        'title',
        'content',
        'category',
        'embedding',
    ];

    protected $casts = [
        'embedding' => 'array',
    ];

    public function generateEmbedding()
    {
        $text = "{$this->title}\n\n{$this->content}";
        $response = Embeddings::for([$text])
            ->dimensions(768)
            ->generate();

        $this->update(['embedding' => $response->embeddings[0]]);
    }
}
