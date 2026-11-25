namespace AngularApi.Models;

public sealed class Room
{
    public string Id { get; set; } = "";
    public string Number { get; set; } = "";
    public string Category { get; set; } = "";
    public int Capacity { get; set; }
    public int Floor { get; set; }
    public decimal PricePerNight { get; set; }
    public bool IsAvailable { get; set; }
}
