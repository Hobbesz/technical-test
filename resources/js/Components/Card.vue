<template>
    <div class="container mx-auto">
        <div class="rounded-lg">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t bg-white">
                <h3 class="text-lg font-semibold">
                    <slot name="header"></slot>
                </h3>
            </div>

            <div class="px-4 py-2 rounded-b-lg bg-white">
                <slot name="content"></slot>
            </div>
        </div>
    </div>
</template>