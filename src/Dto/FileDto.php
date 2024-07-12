<?php

namespace Do6po\LaravelJodit\Dto;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class FileDto implements Arrayable
{

    private string $fileName;

    private ?string $thumb;

    private ?Carbon $changed;

    private ?string $size;

    public static function byAttributes(array $attributes): self
    {
        $self = new self();

        $self->fileName = Arr::get($attributes, 'fileName');
        $self->thumb = Arr::get($attributes, 'thumb');
        $self->changed = Arr::get($attributes, 'changed');
        $self->size = Arr::get($attributes, 'size');

        return $self;
    }

    public function toArray(): array
    {
        return [
            'file'            => $this->getFileName(),
            'thumb'           => config('app.url') . '/image/resize/storage/filebrowser/' . $this->getFileName(
                ) . '?w=150&h=150',
            'changed'         => $this->getChanged()->format('d/m/Y H:m A'),
            'size'            => $this->getSizeInKb(),
            'thumbIsAbsolute' => true,
            'name'            => $this->getFileName(),
            'type'            => 'image'
        ];
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function hasThumb(): bool
    {
        return !!$this->thumb;
    }

    public function getThumb(): string
    {
        return $this->thumb;
    }

    public function getChanged(): Carbon
    {
        return $this->changed;
    }

    public function getSizeInKb(): string
    {
        $size = $this->getSize() / 1024;

        $size = round($size, config('jodit.file_size_accuracy'));

        return $size . ' kb';
    }

    public function getSize(): string
    {
        return $this->size;
    }
}
