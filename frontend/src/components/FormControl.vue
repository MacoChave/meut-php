<template>
	<div class="flex flex-col gap-2">
		<!-- Label -->
		<label v-if="label" :for="inputId" class="font-medium text-gray-700">{{
			label
		}}</label>
	</div>

	<!-- Text / Number / Email / Password -->
	<template v-if="['text', 'number', 'email', 'password'].includes(type)">
		<input
			:id="inputId"
			:type="type"
			:placeholder="placeholder"
			:value="modelValue as any"
			class="border rounded-lg px-3 py-2 w-full"
			@input="updateValue(($event.target as HTMLInputElement).value)" />
	</template>

	<!-- Textarea -->
	<template v-else-if="type === 'textarea'">
		<textarea
			:id="inputId"
			:placeholder="placeholder"
			:value="modelValue as any"
			class="border rounded-lg px-3 py-2 w-full"
			@input="
				updateValue(($event.target as HTMLTextAreaElement).value)
			"></textarea>
	</template>

	<!-- Select -->
	<template v-else-if="type === 'select'">
		<select
			:id="inputId"
			:value="modelValue as any"
			class="border rounded-lg px-3 py-2 w-full"
			@change="updateValue(($event.target as HTMLSelectElement).value)">
			<option value="" disabled hidden>
				{{ placeholder || 'Seleccione una opción' }}
			</option>
			<option
				v-for="option in options || []"
				:key="option.value"
				:value="option.value">
				{{ option.label }}
			</option>
		</select>
	</template>

	<!-- Radio -->
	<template v-else-if="type === 'radio'">
		<div class="flex flex-col gap-2">
			<div
				v-for="option in options || []"
				:key="option.value"
				class="flex items-center gap-2">
				<input
					type="radio"
					:id="`${inputId}-${option.value}`"
					:name="name || inputId"
					:value="option.value"
					:checked="modelValue === option.value"
					@change="updateValue(option.value)"
					class="mr-2" />
				<label
					:for="`${inputId}-${option.value}`"
					class="text-gray-700">
					{{ option.label }}
				</label>
			</div>
		</div>
	</template>

	<!-- Checkbox -->
	<template v-else-if="type === 'checkbox'">
		<div class="flex flex-col gap-2">
			<div
				v-for="option in options || []"
				:key="option.value"
				class="flex items-center gap-2">
				<input
					type="checkbox"
					:id="`${inputId}-${option.value}`"
					:name="name || inputId"
					:value="option.value"
					:checked="
						Array.isArray(modelValue) &&
						modelValue.includes(option.value)
					"
					@change="
                        ($event) => {
                            const checked = ($event.target as HTMLInputElement).checked;
                            if (Array.isArray(modelValue)) {
                                const newValue = checked 
                                    ? [...modelValue, option.value]
                                    : modelValue.filter(v => v !== option.value);
                                updateValue(newValue);
                            } else {
                                updateValue(checked ? [option.value] : []);
                            }
                        }
                    "
					class="mr-2" />
				<label
					:for="`${inputId}-${option.value}`"
					class="text-gray-700">
					{{ option.label }}
				</label>
			</div>
		</div>
	</template>

	<!-- Date -->
	<template v-else-if="type === 'date'">
		<input
			:id="inputId"
			type="date"
			:placeholder="placeholder"
			:value="modelValue as any"
			class="border rounded-lg px-3 py-2 w-full"
			@input="updateValue(($event.target as HTMLInputElement).value)" />
	</template>

	<!-- Time -->
	<template v-else-if="type === 'time'">
		<input
			:id="inputId"
			type="time"
			:placeholder="placeholder"
			:value="modelValue as any"
			class="border rounded-lg px-3 py-2 w-full"
			@input="updateValue(($event.target as HTMLInputElement).value)" />
	</template>
</template>

<script setup lang="ts">
	import { computed } from 'vue';

	type InputType =
		| 'text'
		| 'number'
		| 'email'
		| 'password'
		| 'date'
		| 'time'
		| 'select'
		| 'checkbox'
		| 'radio'
		| 'textarea';

	interface Option {
		label: string;
		value: string | number | boolean;
	}

	const props = defineProps<{
		modelValue: string | number | boolean | null;
		type: InputType;
		label?: string;
		placeholder?: string;
		options?: Option[]; // For select, radio, checkbox
		rows?: number; // For textarea
		name?: string; // For radio and checkbox groups
	}>();

	const emit = defineEmits<{
		(e: 'update:modelValue', value: any): void;
		(e: 'change', value: any): void;
	}>();

	const updateValue = (value: any) => {
		emit('update:modelValue', value);
		emit('change', value);
	};

	const inputId = computed(() => `${props.name || 'input'}-${props.type}`);
</script>
