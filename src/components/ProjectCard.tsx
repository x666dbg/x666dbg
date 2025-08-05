// src/components/ProjectCard.tsx
'use client' // Kita butuh ini karena ada interaktivitas client-side

import Image from 'next/image';
import { motion } from 'framer-motion';

interface ProjectCardProps {
  imageUrl: string;
  title: string;
  description: string;
  link: string;
  tags: string[];
}

const ProjectCard: React.FC<ProjectCardProps> = ({ imageUrl, title, description, link, tags }) => {
  return (
    <motion.a
      href={link}
      target="_blank"
      rel="noopener noreferrer"
      className="block p-1 rounded-lg"
      whileHover="hover" // State saat di-hover
      initial="initial"   // State awal
      variants={{
        initial: { background: 'transparent' },
        // Latar belakang gradien saat di-hover
        hover: { background: 'linear-gradient(45deg, #00F5C320, #1E1E1E)' }, 
      }}
      transition={{ duration: 0.5 }}
    >
      <div className="bg-dark-card h-full p-4 rounded-md border border-light-text/10
                      flex flex-col gap-4 transition-colors">
        
        <div className="w-full h-48 relative rounded-sm overflow-hidden border border-light-text/10">
          <Image
            src={imageUrl}
            alt={`Screenshot of ${title}`}
            fill
            style={{ objectFit: 'cover' }}
            className="transition-transform duration-500 ease-in-out group-hover:scale-105"
          />
        </div>
        
        <div className="flex-grow">
          <h3 className="text-2xl font-heading text-light-text">{title}</h3>
          <p className="text-base font-body text-subtle-text mt-2">{description}</p>
        </div>
        
        <div className="flex flex-wrap gap-2">
          {tags.map(tag => (
            <span key={tag} className="text-xs font-mono bg-light-text/10 text-neon-accent px-2 py-1 rounded">
              {tag}
            </span>
          ))}
        </div>

      </div>
    </motion.a>
  );
};

export default ProjectCard;