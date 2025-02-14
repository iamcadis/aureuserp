<?php

namespace Webkul\Account\Filament\Clusters\Configuration\Resources\PaymentTermResource\Pages;

use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Webkul\Account\Models\PaymentTerm;
use Webkul\Account\Filament\Clusters\Configuration\Resources\PaymentTermResource;

class CreatePaymentTerm extends CreateRecord
{
    protected static string $resource = PaymentTermResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title(__('accounts::filament/clusters/configurations/resources/payment-term/pages/create-payment-term.notification.title'))
            ->body(__('accounts::filament/clusters/configurations/resources/payment-term/pages/create-payment-term.notification.body'));
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();

        $data['sort'] = PaymentTerm::max('sort') + 1;
        $data['creator_id'] = $user->id;
        $data['company_id'] = $user?->default_company_id;

        return $data;
    }
}
