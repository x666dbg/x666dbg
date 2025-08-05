import React from 'react';

interface SketchyButtonProps extends React.ButtonHTMLAttributes<HTMLButtonElement> {
  children: React.ReactNode;
}

const SketchyButton: React.FC<SketchyButtonProps> = ({ children, className, ...props }) => {
  return (
    <button
      className={`
        bg-white text-gray-800 font-bold py-2 px-6
        border-2 border-gray-800 rounded-lg
        transition-all duration-150 ease-in-out
        shadow-sketchy hover:shadow-sketchy-sm
        hover:-translate-x-0.5 hover:-translate-y-0.5
        active:shadow-none active:translate-x-1 active:translate-y-1
        ${className}
      `}
      {...props}
    >
      {children}
    </button>
  );
};

export default SketchyButton;