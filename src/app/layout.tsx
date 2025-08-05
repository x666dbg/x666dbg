import type { Metadata } from "next";
import { Gochi_Hand, Inter } from "next/font/google";
import "./globals.css";
import { cn } from "@/lib/utils";

// Font untuk Judul
const fontHeading = Gochi_Hand({
  subsets: ["latin"],
  weight: "400",
  variable: '--font-gochi-hand',
});

// Font untuk Teks Biasa
const fontBody = Inter({
  subsets: ["latin"],
  variable: '--font-inter',
});

export const metadata: Metadata = {
  title: "Portofolio Modern [Nama Anda]",
  description: "Dibuat dengan Next.js, Tailwind CSS, dan shadcn/ui",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="id" suppressHydrationWarning>
      <body
        className={cn(
          "min-h-screen font-body antialiased",
          fontHeading.variable,
          fontBody.variable
        )}
      >
        {children}
      </body>
    </html>
  );
}