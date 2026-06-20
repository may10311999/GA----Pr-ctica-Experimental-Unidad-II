using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using aspnet_app.Data;
using aspnet_app.Models;

namespace aspnet_app.Controllers;

[Authorize]
public class TareaController : Controller
{
    private readonly AppDbContext _context;

    public TareaController(AppDbContext context)
    {
        _context = context;
    }

    [AutoValidateAntiforgeryToken]
    public async Task<IActionResult> Index()
    {
        var usuarioId = GetCurrentUserId();
        var tareas = await _context.Tareas
            .Where(t => t.UsuarioId == usuarioId)
            .OrderByDescending(t => t.FechaCreacion)
            .ToListAsync();
        return View(tareas);
    }

    public IActionResult Create()
    {
        return View();
    }

    [HttpPost]
    [ValidateAntiForgeryToken]
    public async Task<IActionResult> Create([Bind("Titulo,Descripcion")] Tarea tarea)
    {
        if (ModelState.IsValid)
        {
            tarea.UsuarioId = GetCurrentUserId();
            tarea.Estado = "pendiente";
            tarea.FechaCreacion = DateTime.UtcNow;
            tarea.FechaActualizacion = DateTime.UtcNow;

            _context.Add(tarea);
            await _context.SaveChangesAsync();

            TempData["MensajeExito"] = "Tarea creada exitosamente.";
            return RedirectToAction(nameof(Index));
        }
        return View(tarea);
    }

    public async Task<IActionResult> Edit(int? id)
    {
        if (id == null) return NotFound();

        var usuarioId = GetCurrentUserId();
        var tarea = await _context.Tareas
            .FirstOrDefaultAsync(t => t.Id == id && t.UsuarioId == usuarioId);

        if (tarea == null) return NotFound();

        return View(tarea);
    }

    [HttpPost]
    [ValidateAntiForgeryToken]
    public async Task<IActionResult> Edit(int id, [Bind("Id,Titulo,Descripcion,Estado")] Tarea tarea)
    {
        if (id != tarea.Id) return NotFound();

        if (ModelState.IsValid)
        {
            try
            {
                var usuarioId = GetCurrentUserId();
                var tareaExistente = await _context.Tareas
                    .FirstOrDefaultAsync(t => t.Id == id && t.UsuarioId == usuarioId);

                if (tareaExistente == null) return NotFound();

                tareaExistente.Titulo = tarea.Titulo;
                tareaExistente.Descripcion = tarea.Descripcion;
                tareaExistente.Estado = tarea.Estado;
                tareaExistente.FechaActualizacion = DateTime.UtcNow;

                await _context.SaveChangesAsync();
                TempData["MensajeExito"] = "Tarea actualizada exitosamente.";
                return RedirectToAction(nameof(Index));
            }
            catch (DbUpdateException)
            {
                ModelState.AddModelError("", "Error al actualizar la tarea.");
            }
        }
        return View(tarea);
    }

    [HttpPost]
    [ValidateAntiForgeryToken]
    public async Task<IActionResult> Delete(int id)
    {
        var usuarioId = GetCurrentUserId();
        var tarea = await _context.Tareas
            .FirstOrDefaultAsync(t => t.Id == id && t.UsuarioId == usuarioId);

        if (tarea == null) return NotFound();

        _context.Tareas.Remove(tarea);
        await _context.SaveChangesAsync();

        TempData["MensajeExito"] = "Tarea eliminada exitosamente.";
        return RedirectToAction(nameof(Index));
    }

    private string GetCurrentUserId()
    {
        return _context.Users
            .Where(u => u.UserName == User.Identity!.Name)
            .Select(u => u.Id)
            .FirstOrDefault() ?? string.Empty;
    }
}
