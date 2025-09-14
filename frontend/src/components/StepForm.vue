<template>
	<div
		class="w-full mx-auto bg-white p-6 rounded-2xl shadow-md mb-4 md:w-4xl">
		<!-- Titulo -->
		<h2 class="text-xl font-semibold mb-4">
			{{ currentStep.title }}
		</h2>
		<!-- Contenido dinámico -->
		<div class="flex flex-col gap-4 justify-center mb-6">
			<!-- @ts-ignore -->
			<slot
				:name="`step-${currentStepIndex}`"
				:formData="props.modelValue"></slot>
		</div>
	</div>

	<!-- Botones -->
	<div class="flex justify-between gap-4">
		<button
			v-if="currentStepIndex > 0"
			@click="prevStep"
			class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
			Atrás
		</button>
		<button
			v-if="!isLastStep"
			@click="nextStep"
			class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-green-700 ml-auto">
			Siguiente
		</button>
		<button
			v-if="isLastStep"
			@click="submit"
			class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 ml-auto">
			Finalizar
		</button>
	</div>
</template>

<script setup lang="ts">
	import { ref, computed } from 'vue';

	interface Step {
		title: string;
		content: any;
	}

	const props = defineProps<{
		steps: Step[];
		modelValue: any;
	}>();

	const currentStepIndex = ref(0);

	// const formData = reactive<Record<string, any>>({});

	const currentStep = computed(() => props.steps[currentStepIndex.value]);

	const emit = defineEmits(['update:modelValue', 'submit']);

	const isLastStep = computed(
		() => currentStepIndex.value === props.steps.length - 1
	);

	const nextStep = () => {
		if (currentStepIndex.value < props.steps.length - 1)
			currentStepIndex.value++;
	};

	const prevStep = () => {
		if (currentStepIndex.value > 0) currentStepIndex.value--;
	};

	const submit = () => {
		emit('submit', props.modelValue);
	};
</script>
