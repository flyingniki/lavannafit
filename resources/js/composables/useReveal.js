import { onMounted, onUnmounted } from 'vue';

/**
 * Adds IntersectionObserver-driven scroll reveal to all `.reveal` elements
 * within the component that calls this composable.
 */
export function useReveal() {
    let observer;

    onMounted(() => {
        observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.12 },
        );

        document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));
    });

    onUnmounted(() => {
        if (observer) observer.disconnect();
    });
}
