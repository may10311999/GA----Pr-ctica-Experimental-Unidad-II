using Microsoft.AspNetCore.Identity.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore;
using aspnet_app.Models;

namespace aspnet_app.Data;

public class AppDbContext : IdentityDbContext
{
    public AppDbContext(DbContextOptions<AppDbContext> options) : base(options)
    {
    }

    public DbSet<Tarea> Tareas { get; set; }

    protected override void OnModelCreating(ModelBuilder builder)
    {
        base.OnModelCreating(builder);

        builder.Entity<Tarea>(entity =>
        {
            entity.ToTable("Tareas");
            entity.HasIndex(e => e.UsuarioId);
            entity.Property(e => e.Estado).HasDefaultValue("pendiente");
            entity.Property(e => e.FechaCreacion).HasDefaultValueSql("datetime('now')");
            entity.Property(e => e.FechaActualizacion).HasDefaultValueSql("datetime('now')");
        });
    }
}
