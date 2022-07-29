import prisma from "../services/prisma";

const create = async (payload: User): Promise<User> => {
  try {
    const user = await prisma.users.create({
      data: { ...payload, role_id: 1 },
      select: {
        password: false,
      },
    });
    return user as User;
  } catch (err) {
    throw err;
  }
};

const createAdmin = async (payload: User): Promise<User> => {
  try {
    const user = await prisma.users.create({
      data: { ...payload, role_id: 2 },
      select: {
        password: false,
      },
    });
    return user as User;
  } catch (err) {
    throw err;
  }
};

const getAll = async (): Promise<User[]> => {
  try {
    const users = (await prisma.users.findMany({
      select: {
        password: false,
      },
      where: {
        role_id: 1, // return only users...
      },
      orderBy: {
        id: "desc",
      },
    })) as User[];
    return users;
  } catch (err) {
    throw err;
  }
};

const getById = async (id: number): Promise<User | null> => {
  try {
    const user = (await prisma.users.findUnique({
      where: {
        id,
      },
      select: {
        password: false,
      },
    })) as User | null;
    return user;
  } catch (err) {
    throw err;
  }
};

const update = async (id: number, payload: User): Promise<User> => {
  try {
    const user = (await prisma.users.update({
      where: {
        id,
      },
      select: {
        password: false,
      },
      data: payload,
    })) as User;
    return user;
  } catch (err) {
    throw err;
  }
};

const drop = async (id: number): Promise<boolean> => {
  try {
    await prisma.users.delete({
      where: { id },
    });
    return true;
  } catch (err) {
    throw err;
  }
};

export { create, getById, getAll, drop, update, createAdmin };
