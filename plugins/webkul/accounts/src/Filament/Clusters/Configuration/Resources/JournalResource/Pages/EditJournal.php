<?php

namespace Webkul\Account\Filament\Clusters\Configuration\Resources\JournalResource\Pages;

use Illuminate\Support\Facades\Auth;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Webkul\Account\Filament\Clusters\Configuration\Resources\JournalResource;
use Webkul\Account\Enums\CommunicationStandard;
use Webkul\Account\Enums\CommunicationType;
use Webkul\Account\Models\Journal;

class EditJournal extends EditRecord
{
    protected static string $resource = JournalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title(__('accounts::filament/clusters/configurations/resources/journal/pages/edit-journal.notification.title'))
            ->body(__('accounts::filament/clusters/configurations/resources/journal/pages/edit-journal.notification.body'));
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['sort'] = Journal::max('sort') + 1;

        $data['creator_id'] = Auth::user()->id;

        $data['invoice_reference_type'] = $data['invoice_reference_type'] ?? CommunicationType::INVOICE->value;
        $data['invoice_reference_model'] = $data['invoice_reference_model'] ?? CommunicationStandard::AUREUS->value;

        return $data;
    }
}
