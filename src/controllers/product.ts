import { Request, Response } from "express";
import ipfsAPI from "ipfs-api";

// Connecting to the ipfs network via infura gateway
const ipfs = ipfsAPI("ipfs.infura.io", "5001", { protocol: "https" });

interface MulterRequest extends Request {
  file: any;
}
export const uploadImage = async (req: Request, res: Response) => {
  const file = (req as MulterRequest).file;

  if (!file) {
    res.status(400).json({ message: "File not found" });
    return;
  }

  try {
    const result = await ipfs.add(file.buffer);
    console.log("result", result[0]);
    const hash = result[0].hash; // should saved to the db to return it from ipfs.get() in the future
    res.status(200).json({
      message: "success",
      data: { path: `https://ipfs.infura.io/ipfs/${result[0].path}`, hash },
    });
  } catch (error) {
    console.log("ipfs image upload error: ", error);
    res.status(500).send({ message: "upload failed", error });
  }
};
