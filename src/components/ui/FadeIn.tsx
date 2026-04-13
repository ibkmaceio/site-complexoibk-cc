interface FadeInProps {
  children: React.ReactNode;
  className?: string;
  delay?: number;
  direction?: "up" | "down" | "left" | "right" | "none";
}

export default function FadeIn({ children, className }: FadeInProps) {
  return <div className={className}>{children}</div>;
}
