'use client'; 

import Image from "next/image";
import { motion, Variants } from "framer-motion";

// Impor komponen baru dari shadcn/ui
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";

// DATA (GANTI DENGAN DATA ANDA)
const projectsData = [
  {
    imageUrl: "/proyek1.png",
    title: "Platform E-Commerce",
    description: "Dibangun dengan Next.js, menampilkan produk dan sistem checkout.",
    tags: ["Next.js", "Tailwind CSS", "Stripe"],
    link: "https://github.com",
  },
  {
    imageUrl: "/proyek2.png",
    title: "Aplikasi Manajemen Tugas",
    description: "Aplikasi task-management dengan React & Firebase.",
    tags: ["React", "Firebase", "Framer Motion"],
    link: "https://github.com",
  },
];
const skillsData = ["JavaScript", "TypeScript", "React", "Next.js", "Node.js", "Tailwind CSS", "Figma", "Prisma"];

const sectionVariants: Variants = {
  hidden: { opacity: 0, y: 50 },
  visible: { 
    opacity: 1, 
    y: 0,
    transition: { duration: 0.8, ease: "easeOut" }
  },
};

export default function Home() {
  return (
    <main className="flex flex-col items-center p-4 sm:p-8 md:p-12 font-body overflow-x-hidden">
      
      <div className="w-full max-w-5xl mx-auto space-y-24 sm:space-y-32 md:space-y-48">
        
        {/* HERO SECTION */}
        <motion.section 
          id="home" 
          className="min-h-[80vh] flex flex-col justify-center items-center text-center"
          initial="hidden"
          animate="visible"
          variants={sectionVariants}
        >
          <p className="font-mono text-primary mb-4">Halo, nama saya adalah</p>
          <h1 className="text-5xl sm:text-7xl md:text-8xl font-heading text-foreground">
            [Nama Anda].
          </h1>
          <h2 className="text-3xl sm:text-5xl md:text-6xl font-heading text-muted-foreground mt-2">
            Saya membangun aplikasi untuk web.
          </h2>
          <p className="max-w-2xl mt-8 text-muted-foreground leading-relaxed">
            Saya seorang developer dengan spesialisasi membuat (dan sesekali mendesain) pengalaman digital yang luar biasa. Saat ini, saya fokus membangun produk yang aksesibel dan berpusat pada pengguna.
          </p>
          <a href="mailto:emailanda@contoh.com" className="mt-12">
            <Button variant="outline" size="lg" className="font-mono text-lg border-2 border-primary text-primary hover:bg-primary/10 hover:text-primary transition-all duration-300 shadow-lg shadow-primary/10 hover:shadow-primary/20">
              Hubungi Saya
            </Button>
          </a>
        </motion.section>

        {/* PROYEK SAYA */}
        <motion.section 
          id="proyek"
          initial="hidden"
          whileInView="visible"
          viewport={{ once: true, amount: 0.2 }}
          variants={sectionVariants}
        >
          <div className="flex items-center gap-4 mb-12">
            <h2 className="text-4xl font-heading text-foreground whitespace-nowrap">Proyek Pilihan</h2>
            <div className="w-full h-[1px] bg-border"></div>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
            {projectsData.map((project, i) => (
              <motion.div key={project.title}
                initial={{ opacity: 0, y: 50 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true, amount: 0.5 }}
                transition={{ duration: 0.5, delay: i * 0.2 }}
              >
                <a href={project.link} target="_blank" rel="noopener noreferrer" className="block h-full">
                  <Card className="h-full bg-card/50 border-border hover:border-primary/50 transition-colors duration-300 flex flex-col group backdrop-blur-sm">
                    <CardHeader className="p-4">
                       <div className="w-full h-48 relative rounded-md overflow-hidden">
                          <Image
                            src={project.imageUrl}
                            alt={`Screenshot of ${project.title}`}
                            fill
                            style={{ objectFit: 'cover' }}
                            className="transition-transform duration-500 ease-in-out group-hover:scale-105"
                          />
                        </div>
                    </CardHeader>
                    <CardContent className="p-4 pt-0 flex-grow flex flex-col">
                      <CardTitle className="font-heading text-2xl mb-2">{project.title}</CardTitle>
                      <p className="text-muted-foreground mb-4 flex-grow">{project.description}</p>
                       <div className="flex flex-wrap gap-2">
                          {project.tags.map(tag => (
                            <span key={tag} className="text-xs font-mono bg-primary/10 text-primary px-2 py-1 rounded">
                              {tag}
                            </span>
                          ))}
                        </div>
                    </CardContent>
                  </Card>
                </a>
              </motion.div>
            ))}
          </div>
        </motion.section>

        {/* KONTAK */}
        <motion.section 
          id="kontak" 
          className="text-center py-16"
          initial="hidden"
          whileInView="visible"
          viewport={{ once: true, amount: 0.3 }}
          variants={sectionVariants}
        >
          <h3 className="font-mono text-primary">03. Apa Selanjutnya?</h3>
          <h2 className="text-5xl font-heading my-4">Get In Touch</h2>
          <p className="max-w-xl mx-auto text-muted-foreground leading-relaxed mb-10">
            Meskipun saya tidak sedang aktif mencari peluang baru, pintu saya selalu terbuka. Jika Anda punya pertanyaan atau hanya ingin menyapa, saya akan berusaha membalasnya!
          </p>
          <div className="mt-12">
            <h3 className="text-2xl font-heading mb-6 text-muted-foreground">Teknologi yang saya gunakan:</h3>
            <div className="flex flex-wrap justify-center gap-4 max-w-2xl mx-auto">
              {skillsData.map(skill => (
                <div key={skill} className="bg-card text-foreground font-mono text-sm py-2 px-3 border rounded-md">
                  {skill}
                </div>
              ))}
            </div>
          </div>
        </motion.section>
      </div>

      <footer className="w-full text-center mt-32 p-4 text-muted-foreground font-mono text-sm">
        <div>Didesain & Dibuat oleh [Nama Anda]</div>
        <div>Terinspirasi oleh para kreator di internet</div>
      </footer>
    </main>
  );
}