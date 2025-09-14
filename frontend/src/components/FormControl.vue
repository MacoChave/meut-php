<template>
	<div class="flex flex-col gap-2">
		<!-- Label -->
		<!-- <label v-if="label" :for="inputId" class="font-medium text-gray-700">{{
			label
		}}</label> -->
	</div>

	<v-text-field
		v-if="['text', 'email', 'password', 'number'].includes(type)"
		:model-value="modelValue"
		@update:model-value="updateValue"
		:label="label"
		:placeholder="placeholder"
		:prepend-icon="prependIcon"
		:append-icon="appendIcon"
		:type="type"
		:id="inputId"
		:disabled="disabled"
		:loading="loading"
		:rules="rules"
		:required="required"
		:error-messages="errorMessages"
		color="primary"
		variant="underlined"
		density="comfortable"
		clearable
		hide-details="auto" />

	<!-- Textarea -->
	<v-textarea
		v-else-if="type === 'textarea'"
		variant="underlined"
		density="comfortable"
		clearable
		hide-details="auto"
		auto-grow
		color="primary"
		@update:model-value="updateValue"
		:rows="rows || 3"
		:model-value="modelValue"
		:label="label"
		:placeholder="placeholder"
		:id="inputId"
		:prepend-icon="prependIcon"
		:append-icon="appendIcon"
		:disabled="disabled"
		:loading="loading"
		:rules="rules"
		:required="required"
		:error-messages="errorMessages" />

	<!-- Select -->
	<v-select
		v-else-if="type === 'select'"
		variant="underlined"
		density="comfortable"
		clearable
		item-title="label"
		item-value="value"
		color="primary"
		:model-value="modelValue"
		:id="inputId"
		:items="options"
		:label="label"
		:placeholder="placeholder"
		:prepend-icon="prependIcon"
		:append-icon="appendIcon"
		:disabled="disabled"
		:loading="disabled"
		:no-data-text="'No hay opciones disponibles'"
		@update:model-value="updateValue" />

	<!-- Checkbox -->
	<v-checkbox
		v-else-if="type === 'checkbox'"
		:model-value="modelValue"
		@update:model-value="updateValue"
		:label="label"
		:disabled="disabled"
		:rules="rules"
		:required="required"
		:error-messages="errorMessages"
		:id="inputId"
		color="primary"
		hide-details="auto" />

	<!-- Switch (alternativa moderna al checkbox) -->
	<v-switch
		v-else-if="type === 'switch'"
		:model-value="modelValue"
		@update:model-value="updateValue"
		:label="label"
		:disabled="disabled"
		:rules="rules"
		:required="required"
		:error-messages="errorMessages"
		:id="inputId"
		color="primary"
		hide-details="auto"
		inset />

	<!-- Radio -->
	<!-- Radio Group -->
	<div v-else-if="type === 'radio'" class="radio-group">
		<v-label v-if="label" class="text-subtitle-1 mb-2">
			{{ label }}
			<span v-if="required" class="text-red-500 ml-1">*</span>
		</v-label>
		<v-radio-group
			:model-value="modelValue"
			@update:model-value="updateValue"
			:disabled="disabled"
			:rules="rules"
			:error-messages="errorMessages"
			:id="inputId"
			:inline="inline"
			hide-details="auto">
			<v-radio
				v-for="option in options"
				:key="option.label"
				:label="option.label"
				:value="option.value"
				:disabled="disabled"
				color="primary" />
		</v-radio-group>
	</div>

	<!-- File Upload -->
	<v-file-input
		v-else-if="type === 'file'"
		variant="outlined"
		density="comfortable"
		hide-details="auto"
		prepend-icon="mdi-paperclip"
		color="primary"
		:model-value="modelValue"
		:label="label"
		:placeholder="placeholder"
		:disabled="disabled"
		:loading="loading"
		:rules="rules"
		:required="required"
		:error-messages="errorMessages"
		:accept="accept"
		:multiple="multiple"
		:id="inputId"
		@update:model-value="updateValue" />

	<!-- Rating -->
	<div v-else-if="type === 'rating'" class="rating-group">
		<v-label v-if="label" class="text-subtitle-1 mb-2">
			{{ label }}
			<span v-if="required" class="text-red-500 ml-1">*</span>
		</v-label>
		<v-rating
			:model-value="parseInt(modelValue?.toString() ?? '')"
			@update:model-value="updateValue"
			:disabled="disabled"
			:id="inputId"
			color="amber"
			half-increments
			hover />
	</div>

	<!-- Slider -->
	<div v-else-if="type === 'slider'" class="slider-group">
		<v-label v-if="label" class="text-subtitle-1 mb-2">
			{{ label }}
			<span v-if="required" class="text-red-500 ml-1">*</span>
		</v-label>
		<v-slider
			:model-value="parseInt(modelValue?.toString() ?? '0')"
			@update:model-value="updateValue"
			:disabled="disabled"
			:rules="rules"
			:error-messages="errorMessages"
			:min="min || 0"
			:max="max || 100"
			:step="step || 1"
			:id="inputId"
			thumb-label
			color="primary"
			hide-details="auto" />
	</div>

	<!-- Date -->
	<template v-else-if="type === 'date'">
		<v-text-field
			:model-value="formatDisplayDate"
			:label="label"
			:placeholder="placeholder"
			:id="inputId"
			readonly
			variant="underlined"
			density="comfortable"
			clearable
			hide-details="auto"
			color="primary"
			prepend-icon="mdi-calendar"
			@click="showMenuDate = true">
			<v-menu
				v-model="showMenuDate"
				:close-on-content-click="false"
				activator="parent">
				<v-date-picker
					v-model="date"
					variant="modern"
					show-adjacent-months
					color="secondary"
					class="custom-date-picker"
					:title="label"
					@update:model-value="updateValue">
				</v-date-picker>
			</v-menu>
		</v-text-field>
	</template>

	<!-- Time -->
	<template v-else-if="type === 'time'">
		<v-text-field
			:model-value="modelValue"
			:id="inputId"
			label="Picker in menu"
			prepend-icon="mdi-clock-time-four-outline"
			readonly
			color="primary">
			<v-menu
				v-model="showMenuTime"
				:close-on-content-click="false"
				activator="parent"
				min-width="0">
				<v-time-picker
					v-model="time"
					variant="modern"
					color="secondary"
					:title="label"
					@update:model-value="updateValue"></v-time-picker>
			</v-menu>
		</v-text-field>
	</template>
</template>

<script setup lang="ts">
	import { ref } from 'vue';
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
		| 'switch'
		| 'radio'
		| 'file'
		| 'slider'
		| 'rating'
		| 'textarea';

	const time = ref(null);
	const showMenuTime = ref(false);

	const date = ref(null);
	const showMenuDate = ref(false);

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
		prependIcon?: string;
		appendIcon?: string;
		disabled?: boolean;
		loading?: boolean;
		required?: boolean;
		rules?: Array<(v: any) => boolean | string>;
		errorMessages?: string | string[];
		// Props específicos para ciertos tipos
		inline?: boolean;
		accept?: string;
		multiple?: boolean;
		min?: number;
		max?: number;
		step?: number;
	}>();

	defineOptions({
		inheritAttrs: false,
	});

	const emit = defineEmits<{
		(e: 'update:modelValue', value: any): void;
		(e: 'change', value: any): void;
		(e: 'blur', event: Event): void;
		(e: 'focus', event: Event): void;
	}>();

	const updateValue = (value: any) => {
		emit('update:modelValue', value);
		emit('change', value);
	};

	const inputId = computed(
		() =>
			`${props.name || 'input'}-${props.type}-${Math.random()
				.toString(36)
				.substr(2, 9)}`
	);

	const formatDisplayDate = computed(() => {
		return props.modelValue
			? new Date(`${props.modelValue}`).toLocaleDateString('es-GT')
			: '';
	});
</script>
