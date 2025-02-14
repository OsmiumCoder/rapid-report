import { RefObject, useEffect, useRef } from 'react';

interface UseDismissProps {
    onDismiss: () => void;
    ignoreRefs: RefObject<HTMLElement>[];
}

/*
  Usage:
      Returns a ref of type T extends HTMLElement.
      When a mousedown event occurs outside the HTMLElement being referenced, the onDismiss callback is fired.
      Any refs that are in the ignoreRefs prop will be ignored if clicked
      Typical usage would be to hide a component when a click occurs outside of it.
*/
export default function useDismiss<T extends HTMLElement>({
    onDismiss,
    ignoreRefs,
}: UseDismissProps) {
    const ref = useRef<T>(null);

    useEffect(() => {
        function handleClickOutside(event: MouseEvent) {
            if (
                ref.current &&
                !ref.current.contains(event.target as Node) &&
                !ignoreRefs.some((ref) => ref.current?.contains(event.target as Node))
            ) {
                onDismiss();
            }
        }

        document.addEventListener('mousedown', handleClickOutside);
        return () => {
            document.removeEventListener('mousedown', handleClickOutside);
        };
    }, []);

    return ref;
}
