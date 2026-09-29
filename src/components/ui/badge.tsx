import * as React from "react";
import { cva, type VariantProps } from "class-variance-authority";
import { cn } from "@/lib/utils";

const badgeVariants = cva(
  "inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2",
  {
    variants: {
      variant: {
        default:
          "border-transparent bg-navy-800 text-white shadow-sm",
        secondary:
          "border-transparent bg-slate-800 text-slate-200",
        destructive:
          "border-transparent bg-rose-500/20 text-rose-300 border-rose-500/30",
        outline: "text-foreground border-border-subtle",
        cyan: "bg-cyan-500/15 text-cyan-400 border-cyan-500/30",
        emerald: "bg-emerald-500/15 text-emerald-400 border-emerald-500/30",
        amber: "bg-amber-500/15 text-amber-400 border-amber-500/30",
        red: "bg-red/15 text-red border-red/30",
      },
    },
    defaultVariants: {
      variant: "default",
    },
  }
);

export interface BadgeProps
  extends React.HTMLAttributes<HTMLDivElement>,
    VariantProps<typeof badgeVariants> {}

function Badge({ className, variant, ...props }: BadgeProps) {
  return (
    <div className={cn(badgeVariants({ variant }), className)} {...props} />
  );
}

export { Badge, badgeVariants };
