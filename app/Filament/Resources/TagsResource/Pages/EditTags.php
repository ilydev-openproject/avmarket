<?php

namespace App\Filament\Resources\TagsResource\Pages;

use App\Filament\Resources\TagsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTags extends EditRecord
{
    protected static string $resource = TagsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function afterSave(): void
    {
        // Mengarahkan ke halaman daftar (index) User
        $this->redirect('/admin/tags');
    }
}
