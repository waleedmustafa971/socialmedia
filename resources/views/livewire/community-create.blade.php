<div>
    <form wire:submit.prevent="createCommunity">
        <div>
            <label for="name">Community Name</label>
            <input type="text" wire:model="name" id="name">
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="description">Description</label>
            <textarea wire:model="description" id="description"></textarea>
            @error('description') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Create Community</button>
    </form>

</div>
