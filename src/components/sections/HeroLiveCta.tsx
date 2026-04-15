"use client";

import { useState, useEffect } from "react";
import Link from "next/link";
import { checkLive } from "@/lib/utils/check-live";

type Props = {
  defaultLabel: string;
};

export default function HeroLiveCta({ defaultLabel }: Props) {
  const [isLive, setIsLive] = useState(false);

  useEffect(() => {
    checkLive().then((result) => {
      if (result.isLive) setIsLive(true);
    });
  }, []);

  if (isLive) {
    return (
      <Link
        href="/ao-vivo"
        className="group relative flex items-center gap-3 px-8 py-4 bg-[#E84C1E] hover:bg-[#C43A12] active:bg-[#C43A12] text-white font-display font-extrabold text-sm tracking-wide rounded transition-all shadow-lg shadow-[#E84C1E]/40 hover:shadow-[#E84C1E]/60 hover:scale-[1.02]"
        aria-label="Estamos transmitindo ao vivo agora — assistir"
      >
        <span className="relative flex w-2.5 h-2.5">
          <span className="absolute inline-flex h-full w-full rounded-full bg-white opacity-75 animate-ping" />
          <span className="relative inline-flex w-2.5 h-2.5 rounded-full bg-white" />
        </span>
        AO VIVO AGORA
      </Link>
    );
  }

  return (
    <Link
      href="/ao-vivo"
      className="flex items-center gap-3 px-8 py-4 border border-white/25 text-white font-display font-bold text-sm tracking-wide rounded hover:border-[#E84C1E] active:border-[#E84C1E] hover:text-white transition-all"
    >
      <span className="w-2 h-2 rounded-full bg-[#E84C1E] animate-pulse" />
      {defaultLabel}
    </Link>
  );
}
