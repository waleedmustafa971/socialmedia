<div>
   <!-- resources/views/livewire/follow-button.blade.php -->

<div>
    @if($isFollowing)
        <button wire:click="toggleFollow" class="px-4 py-2 text-white bg-red-500 rounded">
            Unfollow
        </button>
    @else
        <button wire:click="toggleFollow" class="px-4 py-2 text-white bg-green-500 rounded">
            Follow
        </button>
    @endif
</div>

</div>
