"use client";

import { useState, useEffect } from "react";
import Link from "next/link";
import Image from "next/image";
import { Menu, X, Radio, ChevronDown } from "lucide-react";
import { clsx } from "clsx";

const NAV_LINKS = [
  { label: "A IBK", href: "/sobre" },
  {
    label: "Ministérios",
    href: "/ministerios",
    sub: [
      { label: "Todos os Ministérios", href: "/ministerios" },
      { label: "Lideranças", href: "/liderancas" },
      { label: "Nossa História", href: "/nossa-historia" },
    ],
  },
  { label: "Programação", href: "/programacao" },
  { label: "Eventos", href: "/eventos" },
  {
    label: "Mídia",
    href: "/tv-ibk",
    sub: [
      { label: "TV IBK", href: "/tv-ibk" },
      { label: "Podcasts", href: "/podcasts" },
      { label: "Galeria", href: "/midia" },
    ],
  },
  { label: "Novidades", href: "/novidades" },
  { label: "Contato", href: "/fale-conosco" },
];

export default function Header() {
  const [scrolled, setScrolled] = useState(false);
  const [mobileOpen, setMobileOpen] = useState(false);
  const [activeDropdown, setActiveDropdown] = useState<string | null>(null);
  const [expandedMobile, setExpandedMobile] = useState<string | null>(null);

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 40);
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  return (
    <>
      <header
        className={clsx(
          "fixed top-0 left-0 right-0 z-50 transition-all duration-300",
          scrolled
            ? "bg-[#1A1A1A]/95 backdrop-blur-md shadow-lg"
            : "bg-gradient-to-b from-black/60 to-transparent"
        )}
      >
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between h-16 lg:h-20">
            {/* Logo */}
            <Link href="/" className="flex items-center gap-3 shrink-0">
              <Image
                src="/assets/logo/logo-branco.png"
                alt="IBK — Igreja Batista Koinonia"
                width={160}
                height={40}
                className="h-8 lg:h-10 w-auto object-contain"
              />
            </Link>

            {/* Desktop Nav */}
            <nav className="hidden lg:flex items-center gap-1" aria-label="Navegação principal">
              {NAV_LINKS.map((link) => (
                <div
                  key={link.href}
                  className="relative group"
                  onMouseEnter={() => link.sub && setActiveDropdown(link.href)}
                  onMouseLeave={() => setActiveDropdown(null)}
                  onFocus={() => link.sub && setActiveDropdown(link.href)}
                  onBlur={(e) => {
                    if (!e.currentTarget.contains(e.relatedTarget as Node)) {
                      setActiveDropdown(null);
                    }
                  }}
                >
                  <Link
                    href={link.href}
                    className="px-3 py-2 text-sm font-display font-semibold text-white/90 hover:text-white transition-colors"
                    aria-haspopup={link.sub ? "true" : undefined}
                    aria-expanded={link.sub ? activeDropdown === link.href : undefined}
                  >
                    {link.label}
                  </Link>

                  {/* Dropdown */}
                  {link.sub && activeDropdown === link.href && (
                    <div className="absolute top-full left-0 mt-1 w-52 bg-[#1A1A1A] border border-white/10 rounded shadow-xl overflow-hidden">
                      {link.sub.map((sub) => (
                        <Link
                          key={sub.href}
                          href={sub.href}
                          className="block px-4 py-2.5 text-sm text-white/80 hover:text-white hover:bg-[#D4521A]/10 transition-colors"
                        >
                          {sub.label}
                        </Link>
                      ))}
                    </div>
                  )}
                </div>
              ))}
            </nav>

            {/* Right CTAs */}
            <div className="hidden lg:flex items-center gap-3">
              <Link
                href="/ao-vivo"
                className="flex items-center gap-1.5 px-4 py-2 bg-[#D4521A] hover:bg-[#B34215] text-white text-sm font-display font-bold rounded transition-colors"
              >
                <Radio size={14} />
                Ao Vivo
              </Link>
            </div>

            {/* Mobile menu button */}
            <button
              className="lg:hidden p-3 text-white"
              onClick={() => setMobileOpen(!mobileOpen)}
              aria-label="Menu"
              aria-expanded={mobileOpen}
            >
              {mobileOpen ? <X size={24} /> : <Menu size={24} />}
            </button>
          </div>
        </div>

        {/* Mobile Menu */}
        {mobileOpen && (
          <div className="lg:hidden bg-[#1A1A1A] border-t border-white/10">
            <nav className="max-w-7xl mx-auto px-4 py-4 flex flex-col gap-1" aria-label="Menu mobile">
              {NAV_LINKS.map((link) => (
                <div key={link.href}>
                  {link.sub ? (
                    <>
                      {/* Link principal com botão de expansão */}
                      <div className="flex items-center justify-between border-b border-white/5">
                        <Link
                          href={link.href}
                          className="flex-1 py-2.5 text-white/90 hover:text-white font-display font-semibold transition-colors"
                          onClick={() => setMobileOpen(false)}
                        >
                          {link.label}
                        </Link>
                        <button
                          type="button"
                          className="p-2 text-white/60 hover:text-white transition-colors"
                          onClick={() => setExpandedMobile(expandedMobile === link.href ? null : link.href)}
                          aria-expanded={expandedMobile === link.href}
                          aria-label={`Expandir ${link.label}`}
                        >
                          <ChevronDown
                            size={16}
                            className={clsx(
                              "transition-transform duration-200",
                              expandedMobile === link.href && "rotate-180"
                            )}
                          />
                        </button>
                      </div>
                      {/* Sub-links */}
                      {expandedMobile === link.href && (
                        <div className="pl-4 pb-1 flex flex-col gap-0.5">
                          {link.sub.map((sub) => (
                            <Link
                              key={sub.href}
                              href={sub.href}
                              className="py-2 text-sm text-white/70 hover:text-white font-body transition-colors"
                              onClick={() => setMobileOpen(false)}
                            >
                              {sub.label}
                            </Link>
                          ))}
                        </div>
                      )}
                    </>
                  ) : (
                    <Link
                      href={link.href}
                      className="block py-2.5 text-white/90 hover:text-white font-display font-semibold border-b border-white/5 transition-colors"
                      onClick={() => setMobileOpen(false)}
                    >
                      {link.label}
                    </Link>
                  )}
                </div>
              ))}
              <div className="flex gap-3 pt-4">
                <Link
                  href="/ao-vivo"
                  className="flex-1 flex items-center justify-center gap-1.5 py-2 bg-[#D4521A] text-white text-sm font-display font-bold rounded transition-colors hover:bg-[#B34215]"
                  onClick={() => setMobileOpen(false)}
                >
                  <Radio size={14} />
                  Ao Vivo
                </Link>
              </div>
            </nav>
          </div>
        )}
      </header>
    </>
  );
}
