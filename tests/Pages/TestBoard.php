<?php

namespace Mokhosh\FilamentKanban\Tests\Pages;

use Filament\Forms\Components\TextInput;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;
use Mokhosh\FilamentKanban\Tests\Enums\TaskStatus;
use Mokhosh\FilamentKanban\Tests\Models\Task;

class TestBoard extends KanbanBoard
{
    protected function statuses(): Collection
    {
        return TaskStatus::statuses();
    }

    protected function records(): Collection
    {
        return Task::latest('updated_at')->get();
    }

    public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        Task::find($recordId)->update(['status' => $status]);
    }

    protected function getEditModalFormSchema(null|int $recordId): array
    {
        return [
            TextInput::make('title'),
        ];
    }

    protected function getEditModalRecordData($recordId, $data): array
    {
        return Task::find($recordId)->toArray();
    }

    protected function editRecord($recordId, array $data, array $state): void
    {
        Task::find($recordId)->update([
            'title' => $data['title'],
        ]);
    }
}
