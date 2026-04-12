"use client";

import { motion, useInView } from "framer-motion";
import { useRef } from "react";

interface FadeInProps {
  children: React.ReactNode;
  className?: string;
  delay?: number;
  direction?: "up" | "down" | "left" | "right" | "none";
}

export default function FadeIn({
  children,
  className,
  delay = 0,
  direction = "up",
}: FadeInProps) {
  const ref = useRef(null);
  const isInView = useInView(ref, { once: true, margin: "-80px" });

  const initialMap = {
    up:    { opacity: 0, y: 32, filter: "blur(6px)" },
    down:  { opacity: 0, y: -32, filter: "blur(6px)" },
    left:  { opacity: 0, x: 32, filter: "blur(6px)" },
    right: { opacity: 0, x: -32, filter: "blur(6px)" },
    none:  { opacity: 0, filter: "blur(6px)" },
  };

  const animateMap = {
    up:    { opacity: 1, y: 0, filter: "blur(0px)" },
    down:  { opacity: 1, y: 0, filter: "blur(0px)" },
    left:  { opacity: 1, x: 0, filter: "blur(0px)" },
    right: { opacity: 1, x: 0, filter: "blur(0px)" },
    none:  { opacity: 1, filter: "blur(0px)" },
  };

  return (
    <motion.div
      ref={ref}
      className={className}
      initial={initialMap[direction]}
      animate={isInView ? animateMap[direction] : initialMap[direction]}
      transition={{ duration: 0.75, delay, ease: [0.16, 1, 0.3, 1] }}
    >
      {children}
    </motion.div>
  );
}
