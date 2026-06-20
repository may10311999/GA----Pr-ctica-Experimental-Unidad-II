using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace aspnet_app.Models;

public class Tarea
{
    [Key]
    public int Id { get; set; }

    [Required(ErrorMessage = "El titulo es obligatorio")]
    [StringLength(200, MinimumLength = 3, ErrorMessage = "El titulo debe tener entre 3 y 200 caracteres")]
    public string Titulo { get; set; } = string.Empty;

    [StringLength(1000, ErrorMessage = "La descripcion no debe exceder 1000 caracteres")]
    public string? Descripcion { get; set; }

    [Required]
    public string Estado { get; set; } = "pendiente";

    [Required]
    public string UsuarioId { get; set; } = string.Empty;

    public DateTime FechaCreacion { get; set; } = DateTime.UtcNow;

    public DateTime FechaActualizacion { get; set; } = DateTime.UtcNow;
}
