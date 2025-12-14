<template>
  <Teleport to="body">
    <div v-if="active && currentStep" class="fixed inset-0 z-50">
      <!-- Overlay -->
      <div class="absolute inset-0 bg-black/50" @click="allowSkip && finish()"></div>

      <!-- Spotlight -->
      <div
        v-if="targetRect"
        class="absolute bg-transparent ring-4 ring-blue-500 rounded-lg pointer-events-none"
        :style="{
          left: targetRect.left - 4 + 'px',
          top: targetRect.top - 4 + 'px',
          width: targetRect.width + 8 + 'px',
          height: targetRect.height + 8 + 'px'
        }"
      ></div>

      <!-- Tooltip -->
      <div
        class="absolute bg-white rounded-lg shadow-xl p-4 max-w-sm z-10"
        :style="tooltipStyle"
      >
        <h4 class="font-semibold text-gray-900 mb-2">{{ currentStep.title }}</h4>
        <p class="text-sm text-gray-600 mb-4">{{ currentStep.content }}</p>

        <div class="flex items-center justify-between">
          <span class="text-sm text-gray-500">{{ currentIndex + 1 }} / {{ steps.length }}</span>
          <div class="flex gap-2">
            <button v-if="currentIndex > 0" @click="prev" class="px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-100 rounded">
              Back
            </button>
            <button v-if="currentIndex < steps.length - 1" @click="next" class="px-3 py-1.5 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded">
              Next
            </button>
            <button v-else @click="finish" class="px-3 py-1.5 text-sm text-white bg-green-600 hover:bg-green-700 rounded">
              Finish
            </button>
          </div>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<script>
import { ref, computed, watch, nextTick } from 'vue';

export default {
  name: 'SbTour',
  props: {
    steps: { type: Array, default: () => [] },
    modelValue: { type: Boolean, default: false },
    allowSkip: { type: Boolean, default: true }
  },
  emits: ['update:modelValue', 'finish', 'step-change'],
  setup(props, { emit }) {
    const currentIndex = ref(0);
    const targetRect = ref(null);

    const active = computed(() => props.modelValue);
    const currentStep = computed(() => props.steps[currentIndex.value]);

    const tooltipStyle = computed(() => {
      if (!targetRect.value) return { top: '50%', left: '50%', transform: 'translate(-50%, -50%)' };
      return {
        top: targetRect.value.bottom + 16 + 'px',
        left: Math.max(16, targetRect.value.left) + 'px'
      };
    });

    const updateTargetRect = () => {
      if (!currentStep.value?.target) {
        targetRect.value = null;
        return;
      }
      const el = document.querySelector(currentStep.value.target);
      if (el) {
        targetRect.value = el.getBoundingClientRect();
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    };

    const next = () => {
      if (currentIndex.value < props.steps.length - 1) {
        currentIndex.value++;
        emit('step-change', currentIndex.value);
      }
    };

    const prev = () => {
      if (currentIndex.value > 0) {
        currentIndex.value--;
        emit('step-change', currentIndex.value);
      }
    };

    const finish = () => {
      emit('update:modelValue', false);
      emit('finish');
      currentIndex.value = 0;
    };

    watch([active, currentIndex], () => {
      if (active.value) nextTick(updateTargetRect);
    }, { immediate: true });

    return { active, currentIndex, currentStep, targetRect, tooltipStyle, next, prev, finish };
  }
};
</script>
