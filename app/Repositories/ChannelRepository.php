<?php

namespace App\Repositories;

// Model for this repository
use App\Models\Channel;

// Support Facades
use Illuminate\Support\Facades\Log;

// Exception
use Exception;

class ChannelRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the total number of channels available.
     *
     * @return int|boolean
     */
    public function getTotalChannels()
    {
        try {
            return Channel::count();
        } catch (Exception $e) {
            Log::channel('channel')->error('[ChannelRepository:getTotalChannels] Total channels not fetched because an exception occurred: ');
            Log::channel('channel')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Create a new channel.
     *
     * @param  array  $channelDetails
     * @return \App\Models\Channel|boolean
     */
    public function createChannel($channelDetails)
    {
        try {
            return Channel::create($channelDetails);
        } catch (Exception $e) {
            Log::channel('channel')->error('[ChannelRepository:createChannel] New channel not created because an exception occurred: ');
            Log::channel('channel')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Get the paginated list of channels ordered by updated at.
     *
     * @param  int  $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator|boolean
     */
    public function getPaginatedListOfChannelsOrderedByUpdatedAt($perPage)
    {
        try {
            return Channel::orderBy('updated_at', 'desc')->paginate($perPage);
        } catch (Exception $e) {
            Log::channel('channel')->error('[ChannelRepository:getPaginatedListOfChannelsOrderedByUpdatedAt] Paginated list of channels ordered by updated at not fetched because an exception occurred: ');
            Log::channel('channel')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Update the channel by the object.
     *
     * @param  array  $update
     * @param  \App\Models\Channel  $channel
     * @return boolean
     */
    public function updateChannelByObject($update, $channel)
    {
        try {
            return $channel->update($update);
        } catch (Exception $e) {
            Log::channel('channel')->error('[ChannelRepository:updateChannelByObject] Channel not updated by object because an exception occurred: ');
            Log::channel('channel')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Delete the channel by the object.
     *
     * @param  \App\Models\Channel  $channel
     * @return boolean
     */
    public function deleteChannelByObject($channel)
    {
        try {
            return $channel->delete();
        } catch (Exception $e) {
            Log::channel('channel')->error('[ChannelRepository:deleteChannelByObject] Channel not deleted by object because an exception occurred: ');
            Log::channel('channel')->error($e->getMessage());

            return false;
        }
    }

    /**
     * Get the list of all channels ordered by name.
     *
     * @return Illuminate\Database\Eloquent\Collection|boolean
     */
    public function getListOfAllChannelsOrderedByName()
    {
        try {
            return Channel::orderBy('name')->get();
        } catch (Exception $e) {
            Log::channel('channel')->error('[ChannelRepository:getListOfAllChannelsOrderedByName] List of all channels ordered by name not fetched because an exception occurred: ');
            Log::channel('channel')->error($e->getMessage());

            return false;
        }
    }
}
