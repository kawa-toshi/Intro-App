<x-jet-action-section>
    <x-slot name="title">
        アカウント削除
    </x-slot>

    <x-slot name="description">
        アカウントを削除します
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            アカウントが削除されると、全てのデータが削除されます。アカウントの削除前に、しっかり確認してください。
        </div>

        <div class="mt-5">
            <x-jet-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                アカウント削除
            </x-jet-danger-button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingUserDeletion">
            <x-slot name="title">
                アカウント削除
            </x-slot>

            <x-slot name="content">
                本当にアカウントを削除しますか？<br>
                アカウントを削除するとあなたのアプリケーション上のデータが全て削除されます。<br>
                同意する場合は、もう一度パスワードを入力してください。

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-jet-input type="password" class="mt-1 block w-3/4" placeholder="{{ __('Password') }}"
                                x-ref="password"
                                wire:model.defer="password"
                                wire:keydown.enter="deleteUser" />

                    <x-jet-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    アカウントを削除しません
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="deleteUser" wire:loading.attr="disabled">
                    アカウントを削除します
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-jet-action-section>
