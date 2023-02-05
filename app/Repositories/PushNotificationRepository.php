<?php

namespace App\Repositories;

use App\Models\PushNotification;
use Illuminate\Database\Eloquent\Model;

class PushNotificationRepository extends BaseRepository
{
    /**
     * @var string[]
     */
    protected $fieldSearchable = [
        'user_id',
        'device_id',
        'platform',
    ];

    /**
     * @return string[]
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * @return string
     */
    public function model(): string
    {
        return PushNotification::class;
    }

    /**
     * @param array $input
     *
     * @return Model
     */
    public function create(array $input): Model
    {
        $pushNotification = PushNotification::whereUserId($input['user_id'])->first();

        if ($pushNotification) {
            $pushNotification->update($input);
        } else {
            $pushNotification = PushNotification::create($input);
        }

        return $pushNotification;
    }

    /**
     * @param array $input
     *
     * @return bool
     */
    public function destroy(array $input): bool
    {
        $pushNotification = PushNotification::whereDeviceId($input['device_id'])->firstOrFail();
        $pushNotification->delete($input);

        return true;
    }
}
